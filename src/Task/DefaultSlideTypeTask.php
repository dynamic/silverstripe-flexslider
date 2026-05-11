<?php

namespace Dynamic\Flexslider\Task;

use Dynamic\FlexSlider\Model\SlideImage;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\DB;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class DefaultSlideTypeTask
 * @package Dynamic\Flexslider\Task
 */
class DefaultSlideTypeTask extends BuildTask
{
    /**
     * @var string
     */
    private static $segment = 'default-slide-type-task';

    /**
     * @var string
     */
    protected string $title = 'Flexslider - Default Slide Type Task';

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \SilverStripe\PolyExecution\PolyOutput $output
     */
    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $this->setDefaults();
        return 0;
    }

    /**
     *
     */
    protected function setDefaults()
    {
        $default = SlideImage::singleton()->config()->get('defaults');

        if (isset($default['SlideType'])) {
            $baseTable = SlideImage::singleton()->baseTable();

            $tables = [
                $baseTable,
                "{$baseTable}_Versions",
                "{$baseTable}_Live",
            ];

            foreach ($tables as $table) {
                $query = DB::query("SELECT * FROM \"{$table}\" WHERE \"SlideType\" IS NULL");

                foreach ($this->yieldSingle($query) as $record) {
                    DB::prepared_query(
                        "UPDATE \"{$table}\" SET \"SlideType\" = ? WHERE \"ID\" = ?",
                        [$default['SlideType'], $record['ID']]
                    );
                }
            }
        }
    }

    /**
     * @param $list
     * @return \Generator
     */
    protected function yieldSingle($list)
    {
        foreach ($list as $item) {
            yield $item;
        }
    }
}
