function getFileExtensionIcon(fileName) {
    let fileNameExtension = fileName.split('.').pop();

    let icon = null;
    switch (fileNameExtension) {
        // image
        case 'png':
            icon = "fa-file-image";
            break;
        case 'jpg':
            icon = "fa-file-image";
            break;
        case 'gif':
            icon = "fa-file-image";
            break;

            // video
        case 'mp4':
            icon = "fa-file-video";
            break;
        case 'avi':
            icon = "fa-file-video";
            break;

            // audio
        case 'mp3':
            icon = "fa-file-audio";
            break;
        case 'wav':
            icon = "fa-file-audio";
            break;

            // pdf
        case 'pdf':
            icon = "fa-file-pdf";
            break;

            // text
        case 'txt':
            icon = "fa-file-alt";
            break;
        case 'md':
            icon = "fa-file-alt";
            break;

            // office
        case 'doc':
            icon = "fa-file-word";
            break;
        case 'docx':
            icon = "fa-file-word";
            break;
        case 'odt':
            icon = "fa-file-word";
            break;
        case 'xls':
            icon = "fa-file-excel";
            break;
        case 'xlsx':
            icon = "fa-file-excel";
            break;
        case 'ppt':
            icon = "fa-file-excel";
            break;
        case 'pptx':
            icon = "fa-file-excel";
            break;

            //pdf
        case 'pdf':
            icon = "fa-file-pdf";
            break;

            // archive
        case 'zip':
            icon = "fa-file-archive";
            break;
        case 'rar':
            icon = "fa-file-archive";
            break;

        default:
            icon = "fa-file";
            break;
    }

    return icon;
}

$(window).on('load', function() {
    let fileName = $('.announcementFileLabel').html()
    console.log(fileName);
    $('.announcementFileIcon').addClass(getFileExtensionIcon(fileName));
});

$('#fileUpload').on('change', function() {
    let fileName = $(this).val().replace('C:\\fakepath\\', " ");
    $('.fileUploadName').html("<i class='fas " + getFileExtensionIcon(fileName) + " mr-1'></i>" + fileName);
})