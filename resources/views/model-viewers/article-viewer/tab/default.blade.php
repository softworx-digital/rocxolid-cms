<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-md-3 col-xs-12">
            @if ($component->getModel()->image()->exists())
                {!! $component->getModel()->image->getModelViewerComponent()->render('related.show', [
                    'attribute' => 'image',
                    'relation' => 'parent',
                    'size' => '828x',
                ]) !!}
            @else
                {!! $component->getModel()->image()->make()->getModelViewerComponent()->render('related.unavailable', [
                    'attribute' => 'image',
                    'relation' => 'parent',
                    'related' => $component->getModel(),
                ]) !!}
            @endif
            </div>
            <div class="col-md-4 col-xs-12">
                {!! $component->render('include.general-data') !!}
            </div>
            <div class="col-md-5 col-xs-12">
                {!! $component->render('include.meta-data') !!}
            </div>
        @if (false)
            <div class="col-md-4 col-xs-12">
                {!! $component->render('include.opengraph-data') !!}
            </div>
        @endif
        </div>
    </div>
</div>