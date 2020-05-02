$('#fileUpload').on('change', function() {
    let fileName = $(this).val().replace('C:\\fakepath\\', " ");
    $('.fileUploadName').html("<i class = 'material-icons md-18 mr-1'> insert_drive_file </i>" + fileName);
})