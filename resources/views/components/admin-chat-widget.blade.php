<div id="admin-chat-widget" style="position:fixed;bottom:20px;right:20px;z-index:9999;font-family:'Segoe UI',system-ui,sans-serif;">
  {{-- Floating button --}}
  <button id="chat-toggle-btn" onclick="toggleChatWidget()"
    style="width:56px;height:56px;border-radius:50%;background:var(--grad-primary);border:none;color:#fff;
    cursor:pointer;box-shadow:0 8px 24px rgba(139,123,255,0.45);position:relative;display:flex;align-items:center;justify-content:center;transition:transform .2s ease;">
    <x-cs-icon name="message-square" size="22" stroke="2" />
    <span id="chat-unread-badge" style="display:none;position:absolute;top:-4px;right:-4px;background:var(--red);
    color:#fff;font-size:11px;font-weight:800;min-width:20px;height:20px;border-radius:10px;
    display:flex;align-items:center;justify-content:center;padding:0 5px;box-shadow:0 2px 8px rgba(255,114,114,0.6);border:2px solid var(--bg2);">0</span>
  </button>

  {{-- Chat panel --}}
  <div id="chat-panel" style="display:none;position:fixed;bottom:90px;right:24px;width:420px;height:560px;max-height:calc(100vh - 120px);
    background:var(--bg2);border:1px solid var(--border);border-radius:16px;overflow:hidden;
    box-shadow:0 12px 40px rgba(0,0,0,.5);flex-direction:column;z-index:9999;">

    {{-- Header --}}
    <div style="background:var(--bg3);padding:14px 16px;border-bottom:1px solid var(--border);
      display:flex;align-items:center;justify-content:space-between;">
      <span style="font-weight:700;font-size:14px;color:var(--text);display:flex;align-items:center;gap:7px;"><x-cs-icon name="message-square" size="16" stroke="2" /> Coaching Inbox</span>
      <button onclick="toggleChatWidget()"
        style="background:none;border:none;color:var(--text3);cursor:pointer;font-size:16px;">✕</button>
    </div>

    {{-- Body: sidebar + chat --}}
    <div style="flex:1;display:flex;overflow:hidden;">
      {{-- Sidebar --}}
      <div id="chat-sidebar" style="width:180px;border-right:1px solid var(--border);overflow-y:auto;
        background:var(--bg2);flex-shrink:0;display:flex;flex-direction:column;">
        {{-- Filter tabs --}}
        <div style="display:flex;padding:6px;gap:3px;border-bottom:1px solid var(--border);">
          <button id="chat-tab-aktif" class="chat-tab-btn active" onclick="switchTab('aktif')"
            style="flex:1;padding:5px 4px;border:none;border-radius:6px;font-size:10px;font-weight:700;cursor:pointer;font-family:inherit;
            background:var(--bg3);color:var(--text2);">Aktif<span id="tab-count-aktif" style="margin-left:2px;font-size:9px;">0</span></button>
          <button id="chat-tab-arsip" class="chat-tab-btn" onclick="switchTab('arsip')"
            style="flex:1;padding:5px 4px;border:none;border-radius:6px;font-size:10px;font-weight:700;cursor:pointer;font-family:inherit;
            background:var(--bg3);color:var(--text2);">Arsip<span id="tab-count-arsip" style="margin-left:2px;font-size:9px;">0</span></button>
        </div>
        <style>
          .chat-tab-btn.active { background: var(--grad-primary) !important; color: #fff !important; }
          .chat-tab-btn:hover:not(.active) { background: var(--bg4) !important; }
        </style>
        <div id="chat-session-list" style="padding:8px;overflow-y:auto;flex:1;">
          <div style="text-align:center;padding:20px;color:var(--text3);font-size:12px;">Memuat...</div>
        </div>
      </div>

      {{-- Chat detail --}}
      <div id="chat-detail" style="flex:1;display:flex;flex-direction:column;overflow:hidden;">
        <div id="chat-detail-header" style="padding:12px 14px;background:var(--bg3);border-bottom:1px solid var(--border);
          font-size:13px;font-weight:700;color:var(--text);">
          Pilih sesi di sidebar
        </div>
        <div id="chat-messages" style="flex:1;overflow-y:auto;padding:12px;">
          <div style="text-align:center;color:var(--text3);padding:40px 10px;font-size:13px;">
            ← Pilih sesi coaching<br>dari sidebar kiri
          </div>
        </div>
        <div id="chat-input-area" style="display:none;flex-direction:column;gap:6px;padding:10px;border-top:1px solid var(--border);background:var(--bg3);">
          <div style="display:flex;gap:8px;">
            <input type="text" id="chat-input" placeholder="Tulis balasan..."
              style="flex:1;background:var(--bg);border:1px solid var(--border);border-radius:8px;
              padding:10px 12px;color:var(--text);font-size:13px;outline:none;font-family:inherit;"
              onkeydown="if(event.key==='Enter')sendReply()">
            <button onclick="sendReply()"
              style="background:var(--grad-primary);border:none;border-radius:8px;padding:10px 14px;
              color:#fff;font-weight:700;cursor:pointer;font-size:12px;font-family:inherit;">Kirim</button>
          </div>
          <button id="complete-session-btn" onclick="completeSession()"
            style="display:none;width:100%;background:var(--green);border:none;border-radius:8px;
            padding:10px;color:#000;font-weight:700;cursor:pointer;font-size:12px;font-family:inherit;">
            ✓ Selesaikan Sesi
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
var chatWidget = {
  open: false,
  activeId: null,
  tab: 'aktif',
  sessions: [],
  counts: { aktif: 0, arsip: 0 },
  pollTimer: null,
  msgPollTimer: null
};

function toggleChatWidget() {
  var panel = document.getElementById('chat-panel');
  chatWidget.open = !chatWidget.open;
  panel.style.display = chatWidget.open ? 'flex' : 'none';
  if (chatWidget.open) {
    refreshSidebar();
    startPolling();
  } else {
    stopPolling();
  }
}

function switchTab(tab) {
  chatWidget.tab = tab;
  chatWidget.activeId = null;
  document.getElementById('chat-messages').innerHTML = '<div style="text-align:center;color:var(--text3);padding:40px 10px;font-size:13px;">← Pilih sesi dari sidebar</div>';
  document.getElementById('chat-input-area').style.display = 'none';
  document.getElementById('chat-detail-header').textContent = 'Pilih sesi di sidebar';
  document.querySelectorAll('.chat-tab-btn').forEach(function(b) { b.classList.remove('active'); });
  document.getElementById('chat-tab-' + tab).classList.add('active');
  refreshSidebar();
}

function refreshSidebar() {
  fetch('/admin/coaching-inbox/summary?tab=' + chatWidget.tab)
    .then(function(r) { return r.json(); })
    .then(function(data) {
      chatWidget.sessions = data.sessions || [];
      chatWidget.counts = data.counts || { aktif: 0, unread: 0, arsip: 0 };
      renderSidebar();
      renderTabBadges();
      updateUnreadBadge();
    });
}

function renderTabBadges() {
  document.getElementById('tab-count-aktif').textContent = chatWidget.counts.aktif || 0;
  document.getElementById('tab-count-arsip').textContent = chatWidget.counts.arsip || 0;
}

function renderSidebar() {
  var list = document.getElementById('chat-session-list');
  var emptyMsg = chatWidget.tab === 'arsip' ? 'Tidak ada arsip' : 'Tidak ada sesi aktif';
  if (!chatWidget.sessions.length) {
    list.innerHTML = '<div style="text-align:center;padding:20px;color:var(--text3);font-size:11px;">' + emptyMsg + '</div>';
    return;
  }
  list.innerHTML = chatWidget.sessions.map(function(s) {
    var active = chatWidget.activeId === s.id ? 'background:rgba(139,123,255,0.12);border-color:rgba(139,123,255,0.3);' : '';
    var opacity = s.is_closed ? 'opacity:0.6;' : '';
    return '<div onclick="selectSession(' + s.id + ')" style="padding:10px;border-radius:10px;cursor:pointer;margin-bottom:4px;border:1px solid transparent;' + active + opacity + '">' +
      '<div style="display:flex;align-items:center;gap:6px;">' +
      '<span style="width:24px;height:24px;border-radius:50%;background:linear-gradient(135deg,var(--purple),var(--cyan));color:#fff;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;flex-shrink:0;">' + escHtml(s.user_initial) + '</span>' +
      '<span style="font-size:12px;font-weight:600;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + escHtml(s.user_name) + '</span>' +
      (s.unread > 0 && !s.is_closed ? '<span style="background:var(--red);color:#fff;font-size:10px;font-weight:700;min-width:16px;height:16px;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-left:auto;">' + s.unread + '</span>' : '') +
      (s.is_closed ? '<span style="font-size:9px;color:var(--green);margin-left:auto;">✓</span>' : '') +
      '</div>' +
      '<div style="font-size:10px;color:var(--text3);margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + escHtml(s.last_message || '') + '</div>' +
      '<div style="font-size:9px;color:var(--text3);margin-top:1px;">' + s.last_time + '</div>' +
    '</div>';
  }).join('');
}

function updateUnreadBadge() {
  var total = chatWidget.sessions.filter(function(s) { return s.unread > 0 && !s.is_closed; }).length;
  var badge = document.getElementById('chat-unread-badge');
  if (total > 0) {
    badge.textContent = total;
    badge.style.display = 'flex';
  } else {
    badge.style.display = 'none';
  }
}

function selectSession(id) {
  chatWidget.activeId = id;
  renderSidebar();
  document.getElementById('chat-messages').innerHTML = '<div style="text-align:center;padding:20px;color:var(--text3);">Memuat...</div>';
  var s = chatWidget.sessions.find(function(x) { return x.id === id; });
  document.getElementById('chat-detail-header').textContent = s ? s.user_name + ' — ' + s.package : 'Chat';
  var area = document.getElementById('chat-input-area');
  if (s && s.is_closed) {
    area.style.display = 'none';
    stopMsgPolling();
  } else {
    area.style.display = 'flex';
    area.style.flexDirection = 'column';
    startMsgPolling();
  }
  loadMessages(id);
}

function loadMessages(id) {
  fetch('/admin/coaching-inbox/' + id + '/messages')
    .then(function(r) { return r.json(); })
    .then(function(data) {
      var detail = document.getElementById('chat-detail');
      var s = chatWidget.sessions.find(function(x) { return x.id === id; });
      document.getElementById('chat-detail-header').textContent = s ? s.user_name + ' — ' + s.package : 'Chat';
      renderMessages(data.messages || []);
      // Toggle complete button & input
      var area = document.getElementById('chat-input-area');
      if (data.is_closed) {
        if (area) area.style.display = 'none';
        stopMsgPolling();
        // Show closed banner
        container.innerHTML += '<div style="text-align:center;padding:12px;margin-top:8px;background:rgba(43,230,186,0.08);border:1px solid rgba(43,230,186,0.2);border-radius:10px;color:var(--green);font-size:12px;font-weight:600;">✅ Sesi selesai — read only</div>';
      } else {
        if (area) { area.style.display = 'flex'; area.style.flexDirection = 'column'; }
        var doneBtn = document.getElementById('complete-session-btn');
        var chatInput = document.getElementById('chat-input');
        var sendBtn = document.querySelector('#chat-input-area > div button');
        if (chatInput) chatInput.style.display = '';
        if (sendBtn) sendBtn.style.display = '';
        if (doneBtn) doneBtn.style.display = 'block';
      }
      // Refresh sidebar for unread
      refreshSidebar();
    });
}

function renderMessages(msgs) {
  var container = document.getElementById('chat-messages');
  container.innerHTML = msgs.map(function(m) {
    var align = m.is_admin ? 'flex-end' : 'flex-start';
    var bg = m.is_admin ? 'var(--purple-btn)' : 'var(--bg3)';
    var color = m.is_admin ? '#fff' : 'var(--text)';
    return '<div style="display:flex;justify-content:' + align + ';margin-bottom:8px;">' +
      '<div style="max-width:85%;">' +
      '<div style="font-size:10px;color:var(--text3);margin-bottom:2px;">' + escHtml(m.sender) + ' · ' + m.time + '</div>' +
      '<div style="background:' + bg + ';color:' + color + ';padding:8px 12px;border-radius:12px;font-size:13px;line-height:1.4;">' + escHtml(m.message) + '</div>' +
      '</div></div>';
  }).join('');
  container.scrollTop = container.scrollHeight;
}

function sendReply() {
  var input = document.getElementById('chat-input');
  var msg = input.value.trim();
  if (!msg || !chatWidget.activeId) return;
  input.value = '';
  var token = document.querySelector('meta[name="csrf-token"]');
  fetch('/admin/coaching-inbox/' + chatWidget.activeId + '/reply', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token.getAttribute('content'), 'Accept': 'application/json' },
    body: JSON.stringify({ message: msg })
  }).then(function(r) { return r.json(); })
    .then(function(data) {
      if (data.success) loadMessages(chatWidget.activeId);
    });
}

function completeSession() {
  if (!chatWidget.activeId) return;
  showCustomConfirm({
    title: 'Selesaikan Sesi Coaching?',
    text: 'Sesi ini akan ditandai selesai dan user bisa membeli paket coaching baru.',
    confirmText: 'Selesaikan Sesi',
    onConfirm: function() {
      var token = document.querySelector('meta[name="csrf-token"]');
      fetch('/admin/coaching-inbox/' + chatWidget.activeId + '/complete', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': token.getAttribute('content'), 'Accept': 'application/json' }
      }).then(function(r) { return r.json(); })
        .then(function(data) {
          if (data.success) {
            loadMessages(chatWidget.activeId);
            refreshSidebar();
          }
        });
    }
  });
}

function startPolling() {
  stopPolling();
  chatWidget.pollTimer = setInterval(refreshSidebar, 5000);
}

function stopPolling() {
  if (chatWidget.pollTimer) clearInterval(chatWidget.pollTimer);
  if (chatWidget.msgPollTimer) clearInterval(chatWidget.msgPollTimer);
}

function startMsgPolling() {
  stopMsgPolling();
  chatWidget.msgPollTimer = setInterval(function() {
    if (chatWidget.activeId) loadMessages(chatWidget.activeId);
  }, 4000);
}

function stopMsgPolling() {
  if (chatWidget.msgPollTimer) clearInterval(chatWidget.msgPollTimer);
  chatWidget.msgPollTimer = null;
}

function escHtml(s) { return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

// Initial unread check and continuous background polling for unread badge
function refreshSidebarQuietly() {
  fetch('/admin/coaching-inbox/summary?tab=aktif')
    .then(function(r) { return r.json(); })
    .then(function(data) {
      if (!data) return;
      chatWidget.sessions = data.sessions || [];
      chatWidget.counts = data.counts || { aktif: 0, unread: 0, arsip: 0 };
      if (chatWidget.open) {
        renderSidebar();
        renderTabBadges();
      }
      updateUnreadBadge();
    })
    .catch(function(e) {});
}

document.addEventListener('DOMContentLoaded', function() {
  refreshSidebarQuietly();
  setInterval(refreshSidebarQuietly, 4000);
});
</script>
