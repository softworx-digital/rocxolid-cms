<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                {!! $component->render('panel.default', [ 'param' => 'data.general' ]) !!}
            </div>
            <div class="col-md-6 col-xs-12">
                {!! $component->render('panel.default', [ 'param' => 'data.meta' ]) !!}
                {!! $component->render('panel.extended', [ 'param' => 'data.extended' ]) !!}
            </div>
            {{-- <div class="col-md-4 col-xs-12">
                {!! $component->render('panel.default', [ 'param' => 'data.opengraph' ]) !!}
            </div> --}}
        </div>
    </div>
</div>