<div id="{{ $component->getDomId('modal-palceholders') }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }}@if (false) <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small>@endif</h4>
            </div>
            <div class="modal-body">
            @foreach ($component->getModel()->getDependenciesProvider()->provideDependencies(true) as $dependency)
                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" href="{{ $component->getDomIdHash($dependency->getAssignmentDefaultName()) }}" style="cursor: pointer;">
                    {{-- @todo ugly --}}
                    @if (is_a($dependency, \Softworx\RocXolid\CMS\Models\DataDependency::class))
                        <span>&bull; {{ $dependency->getTranslatedTitle($component->getController()) }}</span>
                    @else
                        <span>{{ $dependency->getTranslatedTitle($component->getController()) }}</span>
                    @endif
                    </div>
                    <div id="{{ $component->getDomId($dependency->getAssignmentDefaultName()) }}" class="panel-collapse collapse">
                        <div class="panel-body padding-0">
                            <ul class="list-group padding-0 margin-0">
                            @foreach ($dependency->provideDependencyDataPlaceholders() as $placeholder)
                                <li class="list-group-item padding-0">
                                    <div class="btn-group btn-group-sm padding-0 margin-0 margin-right-5" style="min-height: 0;">
                                        <button
                                            class="btn btn-primary"
                                            title="{{ $component->translate('button.add-placeholder') }}"
                                            data-dependency="{{ $placeholder->getToken() }}"
                                            data-title="[{{ $placeholder->getTranslatedTitle($component->getController()) }}]">
                                            <i class="fa fa-chevron-left"></i>
                                        </button>
                                        <button
                                            class="btn btn-primary"
                                            title="{{ $component->translate('button.add-placeholder-close') }}"
                                            data-dependency="{{ $placeholder->getToken() }}"
                                            data-dismiss="modal"
                                            data-title="[{{ $placeholder->getTranslatedTitle($component->getController()) }}]">
                                            <i class="fa fa-chevron-circle-left"></i>
                                        </button>
                                    </div>
                                    <span class="margin-top-2">{{ $placeholder->getTranslatedTitle($component->getController()) }}</span>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
            </div>
        </div>
    </div>
</div>