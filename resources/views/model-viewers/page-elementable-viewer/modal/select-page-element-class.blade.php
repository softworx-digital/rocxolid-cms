<div id="{{ $component->makeDomId('modal-select-page-element-class') }}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} @if ($component->getModel()->exists()) - {{ $component->getModel()->getTitle() }} @endif <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small></h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                    @foreach ($component->getModel()->getPageElementModels(true) as $category => $classes)
                        <h2>{{ $component->translate(sprintf('category.%s', $category)) }}</h2>
                        <div class="row">
                        @foreach ($classes as $short_class => $model)
                            @if ($page_element_class_action == 'create')
                            <div class="col-xs-3">
                                <a class="btn btn-info col-xs-12" data-dismiss="modal" data-ajax-url="{{ $model->getControllerRoute($page_element_class_action, [ '_section' => 'page-elements', $component->getModel()->getRequestFieldName() => $component->getModel()->id ]) }}">
                                @if ($category == 'containers')
                                    <i class="fa fa-list-alt pull-left" style="margin-top: 2px;"></i>
                                @elseif ($category == 'proxy')
                                    <i class="fa fa-cloud pull-left" style="margin-top: 2px;"></i>
                                @else
                                    <i class="fa fa-puzzle-piece pull-left" style="margin-top: 2px;"></i>
                                @endif
                                    {{ __(sprintf('rocXolid::cms-%s.model.title.singular', $short_class)) }}
                                </a>
                            </div>
                            @else
                            <div class="col-xs-3">
                                <a class="btn btn-info col-xs-12" data-dismiss="modal" data-ajax-url="{{ $component->getModel()->getControllerRoute('listPageElement', [ 'page_element_short_class' => $short_class ]) }}">
                                @if ($category == 'containers')
                                    <i class="fa fa-list-alt pull-left" style="margin-top: 2px;"></i>
                                @elseif ($category == 'proxy')
                                    <i class="fa fa-cloud pull-left" style="margin-top: 2px;"></i>
                                @else
                                    <i class="fa fa-puzzle-piece pull-left" style="margin-top: 2px;"></i>
                                @endif
                                    {{ __(sprintf('rocXolid::cms-%s.model.title.singular', $short_class)) }}
                                </a>
                            </div>
                            @endif
                        @endforeach
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close', false) }}</button>
            </div>
        </div>
    </div>
</div>