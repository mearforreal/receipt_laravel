
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Загрузить чек</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="upload_receipt_form" enctype="multipart/form-data">
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Фото</label>
                        <input class="form-control" name="foto" type="file" id="formFile" required>
                      </div>
                      <div class="mb-3">
                      <label for="formSelect" class="form-label">Статус</label>
                    <select class="form-select" name="status" aria-label="Default select example" id="formSelect" required>
                        @foreach($receiptStatusEnum as $enum)
                            <option value="{{ $enum->value }}">{{ $enum->value }}</option>
                        @endforeach
                    </select>
                </div>
                </div>  
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
          <button type="submit" form="upload_receipt_form" class="btn btn-primary">Отправить</button>
        </div>
      </div>
    </div>
  </div>

