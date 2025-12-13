<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; <script>
                document.write(new Date().getFullYear())
              </script> <div class="bullet"></div> <a href="#">HomeBear</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>

<?php $this->load->view('dist/_partials/js'); ?>

<script>
// Cấu hình mặc định Datatable toàn cục
$.extend(true, $.fn.dataTable.defaults, {
    language: {
        "sProcessing":   "処理中...",
        "sLengthMenu":   "_MENU_ 件表示",
        "sZeroRecords":  "該当データが見つかりません",
        "sInfo":         " _TOTAL_ 件中 _START_ から _END_ を表示",
        "sInfoEmpty":    " 0 件中 0 から 0 を表示",
        "sInfoFiltered": "（全 _MAX_ 件からフィルタリング）",
        "sInfoPostFix":  "",
        "sSearch":       "検索:",
        "sUrl":          "",
        "oPaginate": {
            "sFirst":    "先頭",
            "sPrevious": "前",
            "sNext":     "次",
            "sLast":     "最終"
        }
    },
    pageLength: 25,
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "すべて"]],
    ordering: true,
    order: [[0, 'desc']],
    searching: false,
    info: true
});

</script>