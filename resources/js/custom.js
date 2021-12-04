function confirmDelete(form_id, title, message, button_cancel, button_delete) {
    $('#confirm-modal').remove();

    var html  = '';

    html += '<div class="modal fade in" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">';
    html += '  <div class="modal-dialog">';
    html += '      <div class="modal-content">';
    html += '          <div class="modal-header">';
    html += '              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
    html += '              <h4 class="modal-title" id="confirmModalLabel">' + title + '</h4>';
    html += '          </div>';
    html += '          <div class="modal-body">';
    html += '              <p>' + message + '</p>';
    html += '              <p></p>';
    html += '          </div>';
    html += '          <div class="modal-footer">';
    html += '              <div class="pull-left">';
    html += '                  <button type="button" class="btn btn-danger" onclick="$(\'' + form_id + '\').submit();">' + button_delete + '</button>';
    html += '                  <button type="button" class="btn btn-default" data-dismiss="modal">' + button_cancel + '</button>';
    html += '              </div>';
    html += '          </div>';
    html += '      </div>';
    html += '  </div>';
    html += '</div>';

    $('body').append(html);

    $('#confirm-modal').modal('show');
}
