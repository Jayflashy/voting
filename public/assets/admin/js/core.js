// TINY
$(document).ready(function () {
  0 < $("#tiny1").length &&
    tinymce.init({
      selector: "textarea#tiny1",
      height: 500,
      plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor",
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
      style_formats: [
        { title: "Bold text", inline: "b" },
        { title: "Red text", inline: "span", styles: { color: "#ff0000" } },
        { title: "Red header", block: "h1", styles: { color: "#ff0000" } },
        { title: "Example 1", inline: "span", classes: "example1" },
        { title: "Example 2", inline: "span", classes: "example2" },
        { title: "Table styles" },
        { title: "Table row 1", selector: "tr", classes: "tablerow1" },
      ],
    }); 
});
$(document).ready(function () {
    0 < $("#tiny2").length &&
    tinymce.init({
      selector: "textarea#tiny2",
      height: 300,
      plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor",
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
      style_formats: [
        { title: "Bold text", inline: "b" },
        { title: "Red text", inline: "span", styles: { color: "#ff0000" } },
        { title: "Red header", block: "h1", styles: { color: "#ff0000" } },
        { title: "Example 1", inline: "span", classes: "example1" },
        { title: "Example 2", inline: "span", classes: "example2" },
        { title: "Table styles" },
        { title: "Table row 1", selector: "tr", classes: "tablerow1" },
      ],
    });
});

// Datatable
$(document).ready(function () {
  $("#datatable").DataTable({
    language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  });
  $("#datatable1").DataTable({
    language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  });
  var a = $("#datatable-buttons").DataTable({
    lengthChange: !1,
    language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
    buttons: ["copy", "excel", "pdf", "colvis"],
  });
    a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
  $(".dataTables_length select").addClass("form-select form-select-sm"),
  $("#selection-datatable").DataTable({
    select: { style: "multi" },
    language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  }),
  $("#key-datatable").DataTable({
    keys: !0,
    language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    },
  }),
    a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
  $(".dataTables_length select").addClass("form-select form-select-sm"),
  $("#alternative-page-datatable").DataTable({
    pagingType: "full_numbers",
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $(".dataTables_length select").addClass("form-select form-select-sm");
    },
  }),
  $("#datatable2").DataTable({
  language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
  drawCallback: function () {
    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
  },
  });
    $("#scroll-vertical-datatable").DataTable({
      scrollY: "350px",
      scrollCollapse: !0,
      paging: !1,
      language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
      drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
      },
    }),
    $("#complex-header-datatable").DataTable({
      language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
      drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $(".dataTables_length select").addClass("form-select form-select-sm");
      },
      columnDefs: [{ visible: !1, targets: -1 }],
    }),
    $("#state-saving-datatable").DataTable({
      stateSave: !0,
      language: { paginate: { previous: "<i class='mdi mdi-chevron-left'>", next: "<i class='mdi mdi-chevron-right'>" } },
      drawCallback: function () {
        $(".dataTables_paginate > .pagination").addClass("pagination-rounded"), $(".dataTables_length select").addClass("form-select form-select-sm");
      },
    });
});
