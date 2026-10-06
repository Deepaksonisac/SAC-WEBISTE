'use client'

import { useEffect, useRef, useState } from 'react'
import { motion, useInView } from 'framer-motion'

const STATS = [
  { value: 50, suffix: '+', label: 'Team Members' },
  { value: 15, suffix: '+', label: 'Years of Delivery' },
  { value: 100, suffix: '+', label: 'Projects Delivered' },
  { value: 0, suffix: '', label: 'Pan-India Presence', display: 'Pan-India' },
]

function CountUp({ value, suffix }: { value: number; suffix: string }) {
  const ref = useRef<HTMLSpanElement>(null)
  const inView = useInView(ref, { once: true, margin: '-40px' })
  const [n, setN] = useState(0)

  useEffect(() => {
    if (!inView) return
    let raf = 0
    const start = performance.now()
    const dur = 1400
    const tick = (now: number) => {
      const p = Math.min((now - start) / dur, 1)
      const eased = 1 - Math.pow(1 - p, 3)
      setN(Math.round(eased * value))
      if (p < 1) raf = requestAnimationFrame(tick)
    }
    raf = requestAnimationFrame(tick)
    return () => cancelAnimationFrame(raf)
  }, [inView, value])

  return (
    <span ref={ref}>
      {n}
      {suffix}
    </span>
  )
}

export function StatsRow() {
  return (
    <div className="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
      {STATS.map((s, i) => (
        <motion.div
          key={s.label}
          initial={{ opacity: 0, y: 24 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, margin: '-60px' }}
          transition={{ duration: 0.5, delay: i * 0.08 }}
          className="rounded-xl border border-border bg-card p-6 text-center shadow-sm"
        >
          <div className="font-heading text-3xl font-bold text-primary sm:text-4xl">
            {s.display ? s.display : <CountUp value={s.value} suffix={s.suffix} />}
          </div>
          <div className="mt-2 text-sm text-muted-foreground">{s.label}</div>
        </motion.div>
      ))}
    </div>
  )
}
