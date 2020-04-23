$('#grid table th').each(function(){
    //Клонируем и подставляем селекты в хедер таблицы
    $('.merchant_fields').first().clone().show().appendTo($(this).html(''));
});

$('.merchant_fields:visible').each(function(){
    //Обработка смены значений селектов
    $(this).on('change', function(){
        var selected = $('.merchant_fields:visible option:selected').map(function(){return this.value;}).get();
        $('.merchant_fields:visible option').each(function(){
            if($(this).val() != 0 && $.inArray( $(this).val(), selected ) !== -1){                
                $(this).prop("disabled", true);
            } else {
                $(this).prop("disabled", false);
            }
        });
        
    });
});
//Обработка клика на кнопку импорта
$('#import').click(function(){
    //Проверка на наличие выбранных колонок
    var selected = $('.merchant_fields:visible option:selected').map(function(){ if(this.value != 0){ return this.value; }}).get();
    if(!selected.length){
        alert('Укажите колонки для импорта.');
        return false;
    }
    
    $(this).prop("disabled", true);
    var columns = [], data = [];
    
    //Форматирование данных в удобный для отправки форматформат
    $('#grid table th select').each(function(){        
        columns.push($(this).map(function(i,v) {
            return this.value;
        }).get()[0]);
    });
    
    $('#grid table tbody tr').each(function(){   
        var tr = [];
        $(this).find('td').each(function(){
            tr.push($(this).text());
        });        
        data.push(tr);
    });
    
    //Отправка аякс запроса на сохранение данных и редирект на отображение всех данных таблицы merchant_products
    $.ajax({
        method: "POST",
        url: "/",
        data: { columns: JSON.stringify(columns), data: JSON.stringify(data) }
    })
    .done(function() {
        window.location.href = '/index.php?r=merchant';
    });
});