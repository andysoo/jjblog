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
      $('.user').fadeIn();
      $('.login').hide();
      $('.guest').hide();
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
      $('.user').fadeIn();
      $('.login').hide();
      $('.guest').hide();
      $('.username').html(res.name).fadeIn();
      $('.logout').fadeIn();
    } else {
      autoLogin();
    }
  }, 'json');
}
$(function () {
  $('.user').hide();
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
      $('#code').focus().select();
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
    if (p1.length < 5) {
      $('#passreg').focus().select();
      return;
    }
    var p2 = $('#passreg2').val();
    var n = $('#name').val();
    if (n.length < 1) {
      $('#name').focus().select();
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
          $('.user').hide();
          $('.username').hide();
          $('.logout').hide();
          $('.guest').fadeIn();
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
    var p2 = $('#newpass2').val();
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
    $.post('php/list.php', { parent_id: id }, function (result) {
      // console.log(result);
      $('.panel-heading').html(result.title);
      $('#forumname').html(result.user_id);
      $('#time').html(result.post_date);
      $('#forum-content').html(result.content);
    }, 'json');
    $.post('php/replie.php', { parent_id: id }, function (result) {
      console.log(result);
      $('.list-group').html(result);
    });
  })
});


