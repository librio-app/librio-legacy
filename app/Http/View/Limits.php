<?php

namespace App\Http\View;

use Illuminate\View\View;

class Limits
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $limits = ['10' => '10', '25' => '25', '50' => '50', '100' => '100'];

        $view->with(['limits' => $limits]);
    }
}
