function formValidation(formId, message = null, validationWithId = null){
    var validationMessages = '';
    $('#'+formId).find('.required').each(function() {
        if (this.type != undefined){
            if(this.type == 'radio'){
                /* Validation for radio type input*/
                var option=document.getElementsByName(this.name);
                var newArr = Object.values(option);
                var checkValue = false;
                newArr.forEach((item, index)=>{
                    if (option[index].checked){
                        checkValue = true;
                        return false;
                    }
                })
                if (!checkValue) {
                    validationMessages += "Required: " + this.name+'.';
                }else {
                    $('#error_'+this.name.replaceAll('[]', '')).text('');
                }
                /* Validation for radio type input*/
            }else {
                if (this.value === '' || this.value === undefined || this.value === null){
                    if (validationWithId){
                        validationMessages += "Required: " + this.id+'.';
                    }else {
                        validationMessages += "Required: " + this.name+'.';
                    }
                }else {
                    if (validationWithId){
                        $('#error_'+this.id.replaceAll('[]', '')).text('');
                    }else {
                        $('#error_'+this.name.replaceAll('[]', '')).text('');
                    }
                }
            }
        }
    });

    if (validationMessages !== '') {
        var errors = validationMessages.split(".");
        errors.forEach((item, index)=>{
            item = item.replaceAll('[]', '');
            console.log(item, 'console1');
            var fieldTitle = item.replace('Required: ', '').replaceAll('_', ' ');
            fieldTitle = fieldTitle.charAt(0).toUpperCase() + fieldTitle.slice(1);
            if (message) {
                $('#error_'+item.replace('Required: ', '')).text('This field is required.');
            }else {
                $('#error_'+item.replace('Required: ', '')).text(fieldTitle + ' field is required.');
            }
        })
        return false;
    }
    return true;
}

function validationMessageShow(data, isDefaultMessage = null){
    var error = Object.keys(data.responseJSON.errors);
    var errorData = data.responseJSON.errors;
    var errors = error.map(function (item) {
        return [item, errorData[item]]
    });
    errors.forEach(function(item, index) {
        if (isDefaultMessage){
            $('#error_'+item[0]).text('This field is required');
        }else {
            $('#error_'+item[0]).text(item[1]);
        }
    });
}

function validationMessageClear(formId){
    var allInputs = $('#'+formId).serializeArray();
    allInputs.map(function(item, index) {
        let itemName = item.name.replaceAll('[]', '');
        $('#error_'+itemName).text('');
    });

}
