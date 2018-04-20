//permet de gérée le hover est la selection des étoiles
let selectstart = 0;
$('#starsselecteur').children().on('click',function(){
    selectstart = $(this).attr("data-star");
    $('#starsselecteur').removeClass().addClass('stars'+selectstart).children().last().val(selectstart);
}).on('mouseover', function(){
    $('#starsselecteur').removeClass().addClass('stars'+$(this).attr("data-star"));
}).on('mouseleave', function(){
    $('#starsselecteur').removeClass().addClass('stars'+selectstart);
});
