@extends(backpack_view('blank'))

@section('content')
    <div class="row">
        <div class="col-md-6">
            @include('vendor.backpack.widgets.welcome_widget')
        </div>
        <div class="col-md-6"></div>
        @php
            // Only is user is Super Amdin
            if (backpack_user()->type == '1') {
                Widget::add()
                    ->to('before_content')
                    ->type('div')
                    ->class('row mt-3')
                    ->content([
                        Widget::make()
                            ->type('progress')
                            ->class('card mb-3')
                            ->statusBorder('start')
                            ->accentColor('primary')
                            ->ribbon(['top', 'la-user'])
                            ->progressClass('progress-bar')
                            ->value($userCount)
                            ->description( trans('labels.registered_users') )
                            //->progress((100 * (int) 239) / 1000)
                            //->hint(1000 - 239 . ' more until next milestone.'),
                    ]);
            }
        @endphp
    </div>
    </div>
@endsection
