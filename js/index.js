function lsSave(arr) {
  localStorage['__INFO__'] = JSON.stringify(arr)
}
function lsLoad() {
  var info = localStorage['__INFO__'];
  if (typeof info == 'undefined' || info.length < 54) {
    return null;
  }
  return JSON.parse(info);
}
function signIn(data) {
  $.get('php/login.php', data, function (res) {
    if (res.err) {
      $('#resp').html(res.txt);
    } else {
      lsSave(res.info);
      $('.login').hide();
      $('.username').html(res.info.name).fadeIn();
      $('.logout').fadeIn();
      $('#login').modal('hide');
    }
  }, 'json');
}
function autoLogin() {
  var info = lsLoad();
  // console.log(info);
  if (info) {
    signIn(info);
  }
}
function checkLogin() {
  $.get('php/stat.php', { cmd: 'checkLogin' }, function (res) {
    // console.log(res);
    if (res.login) {
      $('.login').hide();
      $('.username').html(res.name).fadeIn();
      $('.logout').fadeIn();
    } else {
      autoLogin();
    }
  }, 'json');
}
$(function () {
  $('.logout').hide();
  $('.username').hide();
  $('.forum-template').hide();
  checkLogin();
  setInterval(checkLogin, 1000 * 60 * 15);

  // post帖子列表
  $.post("php/list.php", { cmd: 'list' }, function (result) {
    // console.log(result);
    $('#forum-list').html(result);
  });

  $('.login').on('click', function () {
    $.get('php/captcha.php', {}, function (res) {
      $('#captcha').html(res);
    });
    $('#resp').html('');
  })
  // 登陆
  $('.signin').on('click', function () {
    var u = $('#userlogin').val();
    var k = $('#passlogin').val();
    var c = $('#code').val();
    if (u.length < 3) {
      $('#userlogin').focus().select();
      return;
    }
    if (k.length < 4) {
      $('#passlogin').focus().select();
      return;
    }
    if (c.length < 1) {
      $('#code').focus();
      return;
    }
    signIn({ cmd: 'login', user: u, pass: k, code: c });
  });

  $('.register').on('click', function () {
    // $.get('php/captcha.php', {}, function (res) {
    //   $('#captcha').html(res);
    // });
    $('#psmsg').html('');
  })
  // 注册
  $('.reg').on('click', function () {
    var u = $('#userreg').val();
    if (u.length < 3) {
      $('#userreg').focus().select();
      return;
    }
    var p1 = $('#passreg1').val();
    if (p1.length < 4) {
      $('#passreg').focus().select();
      return;
    }
    var p2 = $('#passreg2').val();
    var n = $('#name').val();
    if (n.length < 1) {
      $('#name').focus();
      return;
    }
    console.log(u);
    console.log(p1);
    console.log(p2);
    console.log(n);
    if (p1 != p2) {
      $('#psmsg').html('两次密码不相同！');
    } else {
      $.get('php/reg.php', { cmd: 'reg', user: u, pass: p1, name: n }, function (res) {
        console.log(res);
        if (res.reg) {
          $('#psmsg').html('恭喜您，注册成功');
        } else {
          $('#psmsg').html('姓名被占用');
        }
      }, 'json');
    }
  });

  // 注销
  $('.logout').on('click', function () {
    if (confirm('确定注销吗?')) {
      $.get('php/logout.php', { cmd: "logout" }, function (res) {
        if (res.logout) {
          $('.username').hide();
          $('.logout').hide();
          $('.login').fadeIn();
          localStorage['__INFO__'] = '';
        }
      }, 'json');
    }
  });

  // 改昵称
  $('.rename').on('click', function () {
    var n = $('#newname').val();
    console.log(n);
    $.get('php/rename.php', { newName: n }, function (res) {
      console.log(res);
      if (res.rename) {
        $('.resp').html('修改成功！');
      } else {
        $('.resp').html('姓名被占用！');
      }
      $('.username').html(n);
      lsSave(res.info);
    }, 'json');
  });

  // 改密码
  $('.changepass').on('click', function () {
    var p1 = $('#newpass1').val();
    if (p1.length < 4) {
      $('#newpass1').focus().select();
      return;
    }
    var p2 = $('#newpass2').val();
    if (p2.length < 4) {
      $('#newpass1').focus().select();
      return;
    }
    console.log(p1, p2);
    if (p1 == p2) {
      $('.resp').html('');
      $.get('php/changepass.php', { newpass: p1 }, function (res) {
        console.log(res);
        if (res.changepass) {
          $('.resp').html('修改成功！');
        } else {
          $('.resp').html('修改失败，请重新修改！');
        }
        lsSave(res.info);
      }, 'json');
    } else {
      $('.resp').html('两次密码不相同');
    }
  });

  // 点击列表
  $('#forum-list').on('click', function (e) {
    var id = e.target.children[0].innerHTML;
    $('.starter-template').hide();
    $('.forum-template').fadeIn();
    $.post('php/detail.php', { parent_id: id }, function (result) {
      // console.log(result);
      $('#title').html(result.title);
      $('#parent-id').text(result.parent_id);
      $('#forumname').html(result.user_id);
      $('#time').html(result.post_date);
      $('#forum-content').html(result.content);
    }, 'json');
    $.post('php/reply.php', { cmd: 'replies', parent_id: id }, function (result) {
      // console.log(result);
      $('.list-group').html(result);
    });
  })

  // 发贴
  $('#newpost').on('click', function () {
    var t = $('#text-title').val();
    if (t.length < 1) {
      $('#text-title').focus();
      return;
    }
    var c = $('textarea').val();
    if (c.length < 1) {
      $('textarea').focus();
      return;
    }
    $.post('php/post.php', { cmd: 'post', title: t, content: c }, function (result) {
      if (result.login) {
        $.post("php/list.php", { cmd: 'list' }, function (res) {
          if (result.add) {
            $('#forum-list').html(res);
          } else {
            new Error('加入数据库失败')
          }
        });
      } else {
        $('#login').modal('show');
        $('#resp').html('不是论坛会员，请登录');
      }
    }, 'json');
  })

  $('.btn-xs').on('click', function () {
    $('.resp').html('');
    $('.reply').html('');
  })

  // 回贴
  $('#replies').on('click', function () {
    var c = $('.reply').val();
    var id = $('#parent-id').html();
    // console.log(id);
    if (c.length < 1) {
      $('.reply').focus();
      return;
    }
    $.post('php/reply.php', { cmd: 'reply', content: c, parent_id: id }, function (res) {
      // console.log(res)
      if (res.length < 10) {
        $('.resp').html(res);
      } else {
        $('.resp').html('回复成功');
        $('.list-group').html(res);
      }
    });
  })

  // 管理帖子
  $('#myposts').on('show.bs.modal', function () {
    $.post("php/list.php", { cmd: 'mylist' }, function (result) {
      // console.log(result);
      $('#myforum-list').html(result);
    });
  })

  $('#myforum-list').on('click', function (e) {
    if (confirm('确定删除此贴吗?注意删除后将不能恢复！')) {
      var id = e.target.children[0].innerHTML;
      console.log(id);
      $.post('php/delete.php', { cmd: 'delete', parent_id: id }, function (result) {
        $('#myforum-list').html(result);
      });
    }
  })

  // 删除回贴
  $('#reply-list').on('click', function (e) {
    try {
      var rid = e.target.previousElementSibling.innerHTML;
      var u = e.currentTarget.previousElementSibling.children[0].innerHTML;
      var tid = e.currentTarget.previousElementSibling.previousElementSibling.children[0].innerHTML;
      if (Number(rid) && Number(tid)) {
        console.log(rid);
        console.log(tid);
        if (confirm('确定删除些回复吗?')) {
          $.post('php/delreply.php', { tid: tid, rid: rid, user: u, cmd: 'delreply' }, function (result) {
            $('.list-group').html(result);
          });
        }
      }
    } catch (error) { }
  })
});


