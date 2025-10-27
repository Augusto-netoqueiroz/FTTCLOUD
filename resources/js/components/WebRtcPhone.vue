<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
  initialConfig: { type: Object, required: false, default: () => ({}) }
})

const panelOpen = ref(false)
const ws  = ref('OFF')
const reg = ref('—')
const call = ref('—')

const dotState = computed(() => {
  if (reg.value === 'OK') return 'registered'
  if (ws.value === 'ON')  return 'online'
  if (ws.value === 'OFF') return 'offline'
  return ''
})

function togglePanel(){ panelOpen.value = !panelOpen.value }

let ua = null

onMounted(async () => {
  const cfg = props.initialConfig || {}
  if (!cfg.user || !cfg.pass || !cfg.domain || !cfg.wss) {
    console.warn('SIP config ausente', cfg)
    return
  }
  if (!window.SIP) {
    console.warn('SIP.js não carregado (window.SIP ausente)')
    return
  }

  try {
    ua = new window.SIP.UA({
      uri: `sip:${cfg.user}@${cfg.domain}`,
      transportOptions: { wsServers: [cfg.wss] },
      authorizationUser: cfg.user,
      password: cfg.pass,
      displayName: cfg.displayName || cfg.user,
      traceSip: true,
      rel100: window.SIP.C.supported.SUPPORTED,
      sessionDescriptionHandlerFactoryOptions: {
        constraints: { audio: true, video: false },
        peerConnectionOptions: {
          rtcConfiguration: {
            iceServers: [{ urls: 'stun:stun.l.google.com:19302' }],
            iceCandidatePoolSize: 4
          }
        }
      }
    })

    ua.on('connected', () => { ws.value = 'ON' })
    ua.on('disconnected', () => { ws.value = 'OFF'; reg.value = '—' })
    ua.on('registered',   () => { reg.value = 'OK' })
    ua.on('registrationFailed', () => { reg.value = 'ERRO' })
    ua.on('invite', (incoming) => {
      call.value = 'RINGING'
      panelOpen.value = true
      incoming.on('terminated', () => { call.value = '—' })
    })

    await ua.start()
  } catch (e) {
    console.error('Erro ao iniciar SIP UA', e)
    reg.value = 'ERRO'
  }
})

onBeforeUnmount(async () => { try { if (ua) await ua.stop() } catch {} })
</script>

<template>
  <div class="sp-scope">
    <!-- Botão na navbar -->
    <button class="sp-trigger" type="button" title="Softphone" @click="togglePanel">
      <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.86 19.86 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.86 19.86 0 0 1 2.09 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.3 1.78.57 2.63a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.45-1.14a2 2 0 0 1 2.11-.45c.85.27 1.73.45 2.63.57A2 2 0 0 1 22 16.92z"/>
      </svg>
      <span class="sp-dot" :class="dotState"></span>
    </button>

    <!-- Painel -->
    <div class="sp-panel" :class="{ show: panelOpen }" role="dialog" aria-modal="true" aria-labelledby="spTitle" style="top:72px; right:14px;">
      <div class="sp-hd">
        <div>
          <div id="spTitle" class="sp-title">Softphone</div>
          <div class="sp-status">
            <span>WS {{ ws }}</span> • <span>REG {{ reg }}</span> • <span>CALL {{ call }}</span>
          </div>
        </div>
        <div class="sp-row">
          <button class="sp-iconbtn" type="button" @click="panelOpen=false" aria-label="Fechar">✕</button>
        </div>
      </div>

      <div class="sp-body">
        <div class="sp-display">
          <div class="sp-num">—</div>
          <div class="sp-sub"><span>Pronto</span><span class="sp-badge">status</span></div>
        </div>
        <div class="sp-actions">
          <button class="sp-btn call" type="button">Discar</button>
        </div>
        <div class="sp-row">
          <button class="sp-btn mute" type="button">Mic</button>
          <button class="sp-btn mute" type="button">Áudio</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.sp-scope{ --sp-bg:#fff; --sp-bg-2:#f8fafc; --sp-line:#e5e7eb; --sp-txt:#0f172a; --sp-muted:#6b7280; --sp-acc:#3b82f6; --sp-ok:#10b981; --sp-err:#ef4444; --sp-surface:#f1f5f9; }
:global(.dark) .sp-scope{ --sp-bg:#0f172a; --sp-bg-2:#0b1220; --sp-line:#1e293b; --sp-txt:#e6edf6; --sp-muted:#9aa6b2; }
.sp-trigger{ position:relative; width:34px; height:34px; border-radius:9px; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--sp-line); background:transparent; color:inherit; cursor:pointer; }
.sp-trigger:hover{ background:rgba(148,163,184,.15); }
.sp-dot{ position:absolute; right:-2px; top:-2px; width:9px; height:9px; border-radius:999px; border:2px solid var(--sp-bg-2); background:#94a3b8; }
.sp-dot.online{ background:var(--sp-ok) } .sp-dot.registered{ background:var(--sp-acc) } .sp-dot.offline{ background:var(--sp-err) }
.sp-panel{ position:fixed; z-index:10000; width:220px; background:var(--sp-bg); color:var(--sp-txt); border:1px solid var(--sp-line); border-radius:12px; box-shadow:0 14px 34px rgba(0,0,0,.25); opacity:0; pointer-events:none; transform:translateY(8px); transition:.16s }
.sp-panel.show{ opacity:1; pointer-events:auto; transform:translateY(0) }
.sp-hd{ display:flex; align-items:center; justify-content:space-between; gap:6px; padding:6px 8px; background:var(--sp-bg-2); border-bottom:1px solid var(--sp-line); border-radius:12px 12px 0 0; }
.sp-title{ font-size:11px; font-weight:700 } .sp-status{ font-size:10px; color:var(--sp-muted) }
.sp-row{ display:flex; gap:6px } .sp-iconbtn{ border:1px solid var(--sp-line); background:var(--sp-surface); border-radius:8px; padding:3px 6px; }
.sp-body{ padding:8px; display:grid; gap:8px } .sp-display{ background:var(--sp-surface); border:1px solid var(--sp-line); border-radius:10px; padding:6px 8px; }
.sp-num{ font-size:14px; font-weight:700 } .sp-sub{ font-size:10px; color:var(--sp-muted); margin-top:2px; display:flex; gap:6px; flex-wrap:wrap }
.sp-actions{ display:grid; gap:6px } .sp-btn{ display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:7px 8px; border-radius:9px; font-weight:700; font-size:12px; border:1px solid transparent }
.sp-btn.call{ background:rgba(16,185,129,.12); color:var(--sp-ok); border-color:rgba(16,185,129,.28) }
.sp-btn.mute{ background:var(--sp-surface); border-color:var(--sp-line); flex:1 }
.sp-badge{ font-size:10px; padding:2px 6px; border-radius:999px; border:1px solid var(--sp-line); background:var(--sp-surface); color:var(--sp-muted) }
</style>
