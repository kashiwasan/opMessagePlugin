$(function(){
  $('#messageListLoading').show();  
  messageListLoad();
  $('#messageReceiveListLoadMoreButton').click(function(){
    messageListLoadMore();
  });
});

function messageListLoad()
{
  $.getJSON( 'http://local.kashiwa.jp/json.php?mode=detail' , function(json) {
    $result = $('#messageListTemplate').tmpl(json.data);
    $('#messageList').append($result);
    $('#messageListLoading').hide();
  });
  $('#messageList').show();
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
