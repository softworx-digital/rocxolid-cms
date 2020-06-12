<div id="{{ $component->getDomId('modal-palceholders') }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }}@if (false) <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small>@endif</h4>
            </div>
            <div class="modal-body">
            @foreach ($component->getModel()->getDependenciesProvider()->provideDependencies() as $dependency)
                @dump($dependency)

                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" href="{{ $component->getDomIdHash($dependency->getAssignmentDefaultName()) }}" style="cursor: pointer;">
                        <span>{{ $dependency->getTitle($component->getModel()->getCrudController()) }}</span>
                    </div>
                    <div id="{{ $component->getDomId($dependency->getAssignmentDefaultName()) }}" class="panel-collapse collapse">
                        <div class="panel-body panel-permissions">

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