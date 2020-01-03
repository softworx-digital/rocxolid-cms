<ul id="{{ $component->getDomId('images', $component->getModel()->id) }}" class="list-unstyled images col-xs-12 sortable ajax-overlay" data-update-url="{{ $component->getModel()->getControllerRoute('reorder', [ 'relation' => 'images' ]) }}">
@foreach ($component->getModel()->images as $image)
    <li id="{{ $component->getDomId('gallery-items', get_class($image), $image->id) }}" class="d-inline-block" data-item-id="{{ $image->id }}" data-item-type="{{ get_class($image) }}">
        <div class="img img-small @if ($image->is_model_primary) highlight @endif" @if ($image->is_model_primary) title="{{ __('rocXolid:admin::general.text.image-primary') }}" @endif>
            <img src="{{ asset($image->getPath('small-square')) }}" alt="{{ $image->alt }}"/>
            <div class="btn-group show-up">
                <span class="btn btn-default drag-handle"><i class="fa fa-arrows"></i></span>
                <button class="btn btn-primary" data-ajax-url="{{ $image->getControllerRoute('edit') }}"><i class="fa fa-pencil"></i></button>
                <button class="btn btn-danger" data-ajax-url="{{ $image->getControllerRoute('destroyConfirm') }}"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    </li>
@endforeach
</ul>