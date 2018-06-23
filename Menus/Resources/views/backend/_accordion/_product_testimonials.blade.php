<div class="panel panel-default">
    <div class="panel-heading" id="headingProductTestimonials" role="tab">
        <h4 class="panel-title">
            <a aria-controls="collapseProductTestimonials" aria-expanded="true" data-parent="#accordion" data-toggle="collapse" href="#collapseProductTestimonials" role="button">@lang('cms::cms.product_testimonials')</a>
        </h4>
    </div>
    <div aria-labelledby="headingProductTestimonials" class="panel-collapse collapse" id="collapseProductTestimonials" role="tabpanel">
        <div class="panel-body">
            <div class="form-group">
                <select class="form-control select2" data-allow-clear="true" data-placeholder="" data-width="100%" id="product_testimonial">
                    <option></option>
                    @foreach ($term->getProductTestimonialIdContentOptions() as $productTestimonialId => $productTestimonialContent)
                        <option value="{{ $productTestimonialId }}">{{ strip_tags($productTestimonialContent) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-default btn-xs pull-right" id="product_testimonial_add" type="button">@lang('cms::cms.add_to_menu')</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    $('#product_testimonial_add').click(function () {
        var product_testimonial = document.getElementById('product_testimonial');

        if (product_testimonial.value) { // 1. If has value
            var content = document.getElementById('menu_row_template').innerHTML
                .replace('$data_id', product_testimonial.value)
                .replace('$data_title', product_testimonial.options[product_testimonial.selectedIndex].text)
                .replace('$data_title', product_testimonial.options[product_testimonial.selectedIndex].text)
                .replace('$data_type', 'product_testimonial')
                .replace('$data_type', 'product_testimonial');

            document.querySelectorAll('#nestable .dd-list')[0].innerHTML += content; // 2. Append content to menu nestable
            $(product_testimonial).val(null).trigger('change'); // 3. Set null
        }
    });
    </script>
@endpush
