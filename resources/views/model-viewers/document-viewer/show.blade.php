<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div data-keditor="html">
        <div
            class="content-composition"
            data-snippets-url="{{ $component->getController()->getRoute('pageElementSnippets', $component->getModel()) }}"
            data-preview-pdf-url="{{ $component->getController()->getRoute('previewPdf', $component->getModel()) }}">
        </div>
    </div>

    {!! $component->render('include.footer-panel') !!}
</div>

@push('script')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endpush