<div class="row">
    <div class="col-xs-12 col-md-4 col-xl-2">
    @if ($component->getModel()->image()->exists())
        {!! $component->getModel()->image->getModelViewerComponent()->render('default', [ 'image' => $component->getModel()->image, 'size' => 'mid' ]) !!}
    @endif
    </div>
    <div class="col-xs-12 col-md-8 col-xl-10">
        <h4><a data-ajax-url="{{ $component->getModel()->getControllerRoute('show') }}">{{ $component->getModel()->getTitle() }}</a></h4>
        {!! $component->getModel()->perex !!}
    </div>
</div>