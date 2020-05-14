@foreach ($component->getModel()->getAvailableElements() as $element)
    {!! $element->getSnippetModelViewerComponent($component->getModel()->provideViewTheme())->render() !!}
@endforeach


@if (false)
@foreach ([ 'grid', 'basic', 'general', 'inventory'] as $group)
<div class="panel panel-default">
    <div class="panel-heading">{{ $component->translate(sprintf('group.%s', $group)) }}</div>
    <div class="panel-body">
    @foreach ($component->getModel()->getAvailableElements($group) as $element)
        {!! $element->getSnippetModelViewerComponent($component->getModel()->provideViewTheme())->render() !!}
    @endforeach
    </div>
</div>
@endforeach
@endif