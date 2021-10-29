@forelse ($component->getModel()->elements() as $element)
    {!! $element->getModelViewerComponent()->render($element->getPivotData()->get('template')) !!}
@empty
    @if (isset($no_elements_content))
        {!! $no_elements_content !!}
    @endif
@endforelse