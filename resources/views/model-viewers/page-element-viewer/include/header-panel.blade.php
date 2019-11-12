<div class="x_title">
    <h2>{{ $component->translate('model.title.singular') }} @if ($component->getModel()->exists()) - {{ $component->getModel()->getTitle() }} @endif<small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small></h2>
    <div class="clearfix"></div>
</div>