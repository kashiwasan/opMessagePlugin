$(function(){
  $('#messageListLoading').show();  
  messageListLoad();
  $('#messageReceiveListLoadMoreButton').click(function(){
    messageListLoadMore();
  });
  $('#messageSendButton').click(function(){
    var Body = $('#messageSendText').val();
    $.ajax({
      url: message.message_post_api,
      type: 'POST',
      data: 'member_id=' + message.member_id_to + '&body=' + Body + '&apiKey=' + openpne.apiKey,
      dataType: 'json',
      success: function(data) {
        if(data.status=='success'){
          $('#messageSendText').val('');
          $('#messageReceiveList').html('');
          messageListLoad();
        }else{
          alert(data.message);
        }   
      }
    });
  });
});

function messageListLoad()
{
  $.getJSON( message.message_list_api , {apiKey: openpne.apiKey, member_id: message.member_id_to, order_by: 'ASC'}, function(json) {
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
    $('#messageReceiveList').html($result);
  });
  $('#messageReceiveListLoading').hide();
}
