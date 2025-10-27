import { createApp } from 'vue'
import Softphone from './components/Softphone.vue'

function mountSoftphone() {
  const el = document.getElementById('vue-phone')
  if (!el) return

  let initialConfig = {}
  try {
    const raw = el.getAttribute('data-config')
    if (raw) initialConfig = JSON.parse(raw)
  } catch (e) {
    console.warn('SIP config JSON inválida', e)
  }

  createApp(Softphone, { initialConfig }).mount(el)
}

mountSoftphone()
