var highlight_items =
 [
    {'src' : 'https://player.twitch.tv/?channel=loltyler1&muted=true'},
    {'src' : 'https://player.twitch.tv/?channel=LIRIK&muted=true'},
    {'src' : 'https://player.twitch.tv/?collection=abcDeF1ghIJ2kL'}
]; 

const middle_highlight = document.querySelector("#highlight-stream");
//No streams are displayed
if(middle_highlight)
    middle_highlight = middle_highlight.children[0];

//Cycle logic
function carouselDirection(element){
    //Direction is based on the calling button
    if(element.id = "carousel-left"){
        let item = highlight_items.shift();
        highlight_items.push(item);
    }else{
        let item = highlight_items.pop();
        hightlight_items.unshift(item);
    }
    //iframe to display in always the middle one
    middle_highlight.src = highlight_items[0].src;
}