<?php

namespace Dynamic\Flexslider\Task;

use Dynamic\FlexSlider\Model\SlideImage;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;

/**
 * Class SlideLinkTask
 * @package Dynamic\Flexslider\Task
 */
class SlideLinkTask extends BuildTask
{
    /**
     * @var string
     */
    protected $title = 'Slide Link Migration Task';

    /**
     * @var string
     */
    private static $segment = 'slide-link-migration-task';

    /**
     * @var array
     */
    private $known_links = [];

    /**
     * @param \SilverStripe\Control\HTTPRequest $request
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function run($request)
    {
        $this->migrateLinks();
    }

    /**
     * @throws \SilverStripe\ORM\ValidationException
     */
    protected function migrateLinks()
    {
        $baseTable = SlideImage::singleton()->baseTable();

        $tables = [
            $baseTable,
            "{$baseTable}_Versions",
            "{$baseTable}_Live",
        ];

        foreach ($tables as $table) {
            foreach ($this->yieldSingle(DB::query("SELECT * FROM \"{$table}\"")) as $record) {
                $linkID = $record['PageLinkID'];
                $linkLabel = $record['LinkLabel'];

                $slideLink = $this->findOrMakeLink($linkID, $linkLabel);

                if ($slideLink !== false && $slideLink instanceof Link) {
                    DB::prepared_query(
                        "UPDATE \"{$table}\" SET \"SlideLinkID\" = ? WHERE \"ID\" = ?",
                        [$slideLink->ID, $record['ID']]
                    );
                }
            }
        }
    }

    /**
     * @param $list
     * @return \Generator
     */
    private function yieldSingle($list)
    {
        foreach ($list as $item) {
            yield $item;
        }
    }

    /**
     * @param int $linkID
     * @param string $linkLabel
     * @return bool|mixed|Link
     * @throws \SilverStripe\ORM\ValidationException
     */
    private function findOrMakeLink($linkID = 0, $linkLabel = '')
    {
        if (!$linkID || !($page = SiteTree::get()->byID($linkID))) {
            return false;
        }

        if (isset($this->getKnownLinks()[$linkID])) {
            return $this->getKnownLinks()[$linkID];
        }

        $link = Link::create();
        $link->Type = 'SiteTree';
        $link->SiteTreeID = $linkID;
        $link->Template = 'button';

        if ($linkLabel !== null && $linkLabel !== '') {
            $link->Title = $linkLabel;
        } else {
            $link->Title = $page->Title;
        }

        $link->write();

        $this->addKnownLink($linkID, $link);

        return $link;
    }

    /**
     * @param $linkID
     * @param $linkableLinkID
     * @return $this
     */
    private function addKnownLink($linkID, $linkableLinkID)
    {
        $this->known_links[$linkID] = $linkableLinkID;

        return $this;
    }

    /**
     * @return array
     */
    private function getKnownLinks()
    {
        return $this->known_links;
    }
}
