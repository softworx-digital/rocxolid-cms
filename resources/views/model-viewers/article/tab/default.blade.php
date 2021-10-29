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
            <div class="col-md-9 col-xs-12">
                <div class="row">
                    <div class="col-xs-12">
                        {!! $component->render('panel.access', [ 'param' => 'access' ]) !!}
                        {!! $component->render('panel.default', [ 'param' => 'data.general' ]) !!}
                        {!! $component->render('panel.default', [ 'param' => 'data.meta' ]) !!}
                        {!! $component->render('panel.related', [ 'param' => 'data.related' ]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>