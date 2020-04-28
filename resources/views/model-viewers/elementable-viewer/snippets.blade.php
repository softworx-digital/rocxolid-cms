@foreach ($component->getModel()->getAvailableElements() as $element)
    {!! $element->getModelViewerComponent()->setViewTheme($component->getModel()->provideViewTheme())->render('snippet') !!}
@endforeach