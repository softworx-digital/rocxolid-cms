@if ($component->getModel()->documents->isNotEmpty())
<p class="text-center">{{ $component->translate('model.title.singular') }} <b>{!! $component->getModel()->getTitle() !!}</b> {{ $component->translate('text.following-documents') }}</p>
<div class="text-center">
    <ul class="list-inline">
    @foreach ($component->getModel()->documents as $document)
            <li><a class="label label-info" href="{{ $document->getControllerRoute('show') }}" target="_blank">{{ $document->getTitle() }}</a></li>
    @endforeach
    </ul>
</div>
@else
<p class="text-center">{{ $component->translate('model.title.singular') }} <b>{!! $component->getModel()->getTitle() !!}</b> {{ $component->translate('text.no-following-documents') }}</p>
@endif
<p class="text-center">{{ $component->translate('text.destroy-confirmation') }}?</p>