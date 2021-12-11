<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;

trait Downloadable
{
    /**
     * Creates local scope to run the download
     *
     * @param $query
     * @param array $input
     * @param null|string $filter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDownload($query)
    {
        if (!array_key_exists(Filterable::class, class_uses(get_class()))) {
            throw new \RuntimeException('To download, make sure to use the filterable trait!');
        }

        $request = request();
        $input = $request->input();
        $export = $this->getModelExportClass();
        /** @var Builder $filtered */
        $filtered = $query->filter($input);
        $filtered->orderBy($query->getModel()->getTable() . '.id', 'DESC');

        // Create the model filter instance
        $exportClass = new $export($filtered, $request);

        return ($exportClass)->download($this->getTable() . '.xlsx');
    }

    /**
     * Returns the Export class for the current model.
     *
     * @return string
     */
    public function getModelExportClass()
    {
        return method_exists($this, 'modelExport') ? $this->modelExport() : $this->provideExport();
    }

    /**
     * Returns Export class to be instantiated.
     *
     * @param null|string $export
     * @return string
     */
    public function provideExport($export = null)
    {
        if ($export === null) {
            $export = 'App\\Exports\\' . ucfirst($this->getTable()) . 'Export';
        }

        return $export;
    }
}
