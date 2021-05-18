<div id="{{ $component->getDomId() }}" class="panel-group">
@if (false)
    @if ($component->getModel()->headerImage()->exists())
        {!! $component->getModel()->headerImage->getModelViewerComponent()->render('related.show', [
            'attribute' => 'headerImage',
            'relation' => 'parent',
            'size' => '1920x',
        ]) !!}
    @else
        {!! $component->getModel()->headerImage()->make()->getModelViewerComponent()->render('related.unavailable', [
            'attribute' => 'headerImage',
            'relation' => 'parent',
            'related' => $component->getModel(),
            'placeholder' => 'header-placeholder',
        ]) !!}
    @endif
@endif
    {!! $component->render('include.perex-data') !!}
    {!! $component->render('include.content-data') !!}
</div>