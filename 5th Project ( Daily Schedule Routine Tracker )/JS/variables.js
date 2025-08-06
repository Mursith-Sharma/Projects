
/////////////////////////////////////////////////////////////////////////////////////////////

// $('li').on('click',function(){                    /// basic code
//   $(this).css({
//     color : 'brown',
//     textDecoration : 'line-through'
//   })
// })


// thaniyaga use pannuvathayin ivvaru seiyalam $(this).css('text-decoration','line-through');
// but total aga seiumpothu text-decoration,font-size,etcc... pontra element kku '-' varakoodathu so jquery il textDecoration ena capital il eluthuvom

//////////////////////////////////////////////////////////////////////////////////////////////

//if li brown
//change to black
// else li is black 
// change to brown

                                                                                        // way 1 without css
// $('li').on('click',function(){

//   if($(this).css('color') === 'rgb(75, 36, 18)'){
//     $(this).css({
//     color : 'black',
//     textDecoration : 'none'
//   });
//   }

//   else{
//     $(this).css({
//     color : 'rgb(75, 36, 18)',
//     textDecoration : 'line-through'
//   });
//   }

// })


// when i click routine rgb number inai check pannum. black color il irunthal else ilulla color print aaahum. else ilulla color il irunthal if ilulla color print aagum
// console il rgb mattum check pannuvathal if il rgb mattume kodukka vendum. but else il rgb or rgb kkana sariyana color name kodukka vendum

//////////////////////////////////////////////////////////////////////////////////////////////

// $('ul').on('click','li' function(){                                                    // way 2 (easy) with css
//    $(this).toggleClass('brown') 
// })                                                    // toggleClass koduththal brown enum class add aahi 1st click pannumputhu add aagum 2nd click pannumpothu remove aagum

//////////////////////////////////////// Full function for routine add & remove //////////////////////////////////////////////////////

$('ul').on('click','li', function(){                                                          
   $(this).toggleClass('brown') 
}) 

$('ul').on('click','span', function(){                      // fadeout koduththal after clicked remove that routine
  $(this).parent().fadeOut(600,function(){            // parent koduppathal antha span tag in parent aana li aanathu total aaga remove aagum
    $(this).remove();                                  // intha remove kodukka kaaranam memory il irunthu remove panna. bcz memory il ihaku data temporery aha save ahum
  });                                      
})

$('input').on('keypress',function(e){

  if(e.which === 13){
   let newName = $(this).val()
   $('ul').append(`<li><span>X </span>${newName}</li>`)

   $(this).val('')
  }
})

// யாராவது ஒரு key-ஐ press பண்ணும்போது அந்த function செயல்படும்.
// console il orignalEvent il which entru oru kye irukkum. athatkaana number value um irukkum.
// naam 13 ida kaaranam enter koduththal maththiram add ahum. appadi llavittal summa type pannumpothe add aagividum
// key code patri padikka keycode.info il parkkalam. so enter in key code value 13
//$(this) என்பது அந்த input field-ஐ குறிக்கிறது. .val() என்பது user type பண்ணிய value-ஐ எடுத்துக் கொள்கிறது. இதை newName entra variable il save aahirathu
// Page-இல் உள்ள <ul> க்கு உள்ளே ஒரு புதிய <li> element சேர்க்கப்படும். using append.
//${newName} என்பது JavaScript-இல் variable-ஐ insert செய்யும் வழி. newName என்பது user type pannum text.
// $(this).val('')  ithatkaana reason after enter koduththavudan placeholder emty aahividum
