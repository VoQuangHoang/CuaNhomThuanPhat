<tr>
   
    <td>
        <h4 class="title-kh">Khối header</h4>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div>
                    <label for="">Slider</label>
                    <div class="repeater" id="repeater">
                        <table class="table table-bordered page-table">
                            <tbody class="step-group" id="sortable">

                                @foreach($listSlider as $key => $listSlider)
                                    <tr>
                                        <td>
                                            <div class="row align-items-center">
                                                <div class="col-sm-6">
                                                    <div style="text-align: center;">
                                                        <div class="image">
                                                            <div class="image__thumbnail mb-0">
                                                                <img src="{{ !empty($listSlider->url) ? $listSlider->url : __NO_IMAGE_DEFAULT__ }}"
                                                                    data-init="{{ __NO_IMAGE_DEFAULT__ }}">
                                                                <a href="javascript:void(0)" class="image__delete"
                                                                    onclick="urlFileDelete(this)">
                                                                    <i class="fa fa-times"></i></a>
                                                                <input type="hidden" value="" wire:model="listSlider.{{$key}}.url"
                                                                    name="content[list][{{ $key }}][url]" />
                                                                <div class="image__button" onclick="fileSelect(this)">
                                                                    <i class="fa fa-upload"></i>
                                                                    Upload
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Tiêu đề ảnh</label>
                                                        <input type="text" class="form-control"
                                                            name="content[list][{{ $key }}][text]" wire:model="listSlider.{{$key}}.text">
                                                    </div>
                                                    <div>
                                                        <label for="">Link</label>
                                                        <input type="text" class="form-control"
                                                            name="content[list][{{ $key }}][link]" wire:model="listSlider.{{$key}}.link">
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                        <td class="remove-td-item" style="width: 0px;">
                                            <a class="text-danger buttonremovetable" title="Xóa" wire:click.prevent="removeSlider({{$key}})">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                               
                            </tbody>
                        </table>
                        <div class="text-right" style="margin-bottom: 30px">
                            {{-- <button class="btn btn-sm btn-success" 
                                onclick="repeater(event,this,'{{ route('get.layout') }}','.index',
                            'image2', '.image2')">Thêm ảnh
                            </button> --}}
                            <a class="btn btn-sm btn-success" wire:click.prevent="addSlider">Thêm ảnh
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>
