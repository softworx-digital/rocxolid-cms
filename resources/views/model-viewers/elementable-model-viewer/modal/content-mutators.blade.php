<div id="{{ $component->getDomId('modal-palceholders') }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }}@if (false) <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small>@endif</h4>
            </div>
            <div class="modal-body">
                <ul class="list-group padding-0 margin-0">
                @foreach ($component->getModel()->getMutatorsProvider()->provideMutators() as $mutator)
                    <li class="list-group-item padding-0">
                        <div class="btn-group btn-group-sm padding-0 margin-0 margin-right-5" style="min-height: 0;">
                            <button
                                class="btn btn-primary"
                                title="{{ $component->translate('button.add-mutator-close') }}"
                                data-mutator="{{ $mutator->getParam() }}"
                                @if ($mutator->hasAllowedTextSelectionRegex()) data-mutator-allowed-selection-regex="{{ $mutator->getAllowedTextSelectionRegex() }}" @endif
                                @if ($mutator->isAllowedPlaceholderSelection()) data-mutator-allowed-placeholder="true" @endif
                                data-dismiss="modal"
                                data-title="{{ $mutator->getTitle($component->getController()) }}">
                                <i class="fa fa-chevron-circle-left"></i>
                            </button>
                        </div>
                        <span class="margin-top-2">{{ $mutator->getTitle($component->getController()) }}</span>
                        <i class="fa fa-info-circle margin-left-5" title="{{ $mutator->getHint($component->getController()) }}"></i>
                    </li>
                @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
            </div>
        </div>
    </div>
</div>