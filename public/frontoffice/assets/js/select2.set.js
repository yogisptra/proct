$(document).ready(function() {
    $('.select-with-search').select2({
        "language": {
            "noResults": function(){
                return "Tidak ditemukan.";
            }
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        // placeholder: "Pilih",
        // allowClear: true
    });

    $(document).on('select2:open', () => {
        const searchSelect2 = document.querySelector('.select2-search__field')

        // const getName = searchSelect2.parents()
        // console.log(getName)

        searchSelect2.focus();
        searchSelect2.setAttribute("placeholder", "Cari...");
    });
});