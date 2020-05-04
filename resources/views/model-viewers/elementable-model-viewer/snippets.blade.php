@foreach ($component->getModel()->getAvailableElements() as $element)

    {!! $element->getSnippetModelViewerComponent($component->getModel()->provideViewTheme())->render() !!}

@endforeach