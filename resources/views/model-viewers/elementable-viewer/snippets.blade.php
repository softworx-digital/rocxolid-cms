@foreach ($component->getModel()->getAvailableElements() as $element)
    {!! $element->getModelViewerComponent()->render('snippet') !!}
@endforeach