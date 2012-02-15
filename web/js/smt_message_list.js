$(function(){
  
  messageListLoad();
  $('#messageReceiveListLoadMoreButton').click(function(){
    messageListLoadMore();
  });
});

function messageListLoad()
{
  $.getJSON( 'http://local.kashiwa.jp/json.php' , {'mode': 'list' } , function(json) {
    $result = $('#messageReceiveListTemplate').tmpl(json.data);
    $('.divlink', $result).pushLink();
    $('#messageReceiveList').append($result);
    $('#messageReceiveListLoading').hide();
  });
  $('#messageReceiveList').show();
}

function messageListLoadMore()
{
  $('#messageReceiveListLoading').show();
  var maxId = $('#messageReceiveListLoadMoreButton').attr('data-max-message-id');
  var pageId = $('#messageReceiveListLoadMoreButton').attr('data-message-page-id');
  $.getJSON( openpne.apiBase + 'plugin/message_list.json' , {'apiKey': openpne.apiKey, 'max_id': maxId, 'page_id': pageId,} , function(json) {
    $result = $('#messageReceiveListTemplate').tmpl(json.data);
    $('.divlink', $result).pushLink();
    $('#messageReceiveList').append($result);
  });
  $('#messageReceiveListLoading').hide();
}
