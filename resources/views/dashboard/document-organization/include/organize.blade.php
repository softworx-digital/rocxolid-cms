<div id="{{ $component->getDomId() }}">
    <div class="x_panel ajax-overlay">
        <div class="x_title">
            <div class="row">
                <div class="col-md-8 col-xs-12">
                    <h2 class="text-overflow">
                        {{ $component->translate('text.organization') }}
                    </h2>
                </div>
            </div>
        </div>
        <div class="x_content">
            <div
                class="row sortable masonry-panel-container masonry-panel-container-two-column"
                data-sortable-group="document-type"
                data-update-url="{{ $assignments->get('document_organizer_controller')->getRoute('savePosition') }}">
            @foreach ($assignments->get('document_type_repository')->getQuery()->orderBy('position')->get() as $document_type)
                <div class="padding-10" data-item-type="{{ get_class($document_type) }}" data-item-id="{{ $document_type->getKey() }}">
                    <div class="panel panel-primary margin-0">
                        <div class="panel-heading"><h3>
                        @if (filled($document_type->icon))
                            <i class="fa fa-{{ $document_type->icon }} margin-right-10"></i>
                        @endif
                            {{ $document_type->getTitle() }}
                            <span class="btn btn-default drag-handle btn-sm pull-right"><i class="fa fa-arrows"></i></span>
                        </h3></div>
                    @if (filled($document_type->description))
                        <div class="panel-body">
                            <div class="col-xs-1"><i class="fa fa-info-circle fa-2x text-vertical-align-middle margin-right-5"></i></div>
                            <div class="col-xs-11">{!! $document_type->getAttributeViewValue('description') !!}</div>
                        </div>
                    @endif

                        <ul class="list-group sortable" data-sortable-group="document-type-{{ $document_type->getKey() }}" data-update-url="{{ $assignments->get('document_organizer_controller')->getRoute('savePosition') }}">
                        @foreach ($document_type->allDocuments as $document)
                            <li class="list-group-item margin-0 padding-top-8 padding-bottom-8  clearfix" data-item-type="{{ get_class($document) }}" data-item-id="{{ $document->getKey() }}">
                                <p class="padding-top-5 margin-0 pull-left">{{ $document->getTitle() }}</p>
                                <span class="btn btn-default btn-sm pull-right drag-handle margin-0"><i class="fa fa-arrows"></i></span>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>