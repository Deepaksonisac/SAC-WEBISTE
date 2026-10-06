$file = ".\app\globals.css"

Add-Content $file @"

/* SAC Trust Marquee - Continuous Moving Line */
@keyframes sac-marquee {
  from {
    transform: translateX(0);
  }
  to {
    transform: translateX(-50%);
  }
}

.sac-marquee {
  display: flex;
  width: max-content;
  animation: sac-marquee 45s linear infinite !important;
  will-change: transform;
}

.sac-marquee:hover {
  animation-play-state: running !important;
}
"@

Write-Host "DONE - Marquee moving animation fixed."

Remove-Item -Recurse -Force ".next" -ErrorAction SilentlyContinue

npm run dev'use client'

import { useState } from 'react'
import { AnimatePresence, motion } from 'framer-motion'
import {
  Video,
  KeyRound,
  Flame,
  Building2,
  Wifi,
  Radio,
  Plus,
  Check,
} from 'lucide-react'
import { Reveal } from '@/components/reveal'

const SOLUTIONS = [
  {
    id: 'ip-video-surveillance',
    icon: Video,
    title: 'IP Video Surveillance & Analytics',
    summary: 'On-site monitoring, hosted video and PTZ integration with intelligent video analytics.',
    details: [
      'On-site and cloud-hosted video management',
      'PTZ and multi-sensor camera integration',
      'AI-driven video analytics and event detection',
      'Explosion-proof cameras for hazardous zones',
    ],
  },
  {
    id: 'access-control',
    icon: KeyRound,
    title: 'Access Control Systems',
    summary: 'Turnstiles, flap & boom barriers, vehicle access management, RFID guard tour.',
    details: [
      'Real-time remote control of access',
      'Shrinkage reduction and asset protection',
      'Workplace-safety enforcement',
      'Reduced rekeying costs',
      'Robust data security',
      'Attendance and event reporting',
    ],
    detailsTitle: 'Why an Access Control System',
  },
  {
    id: 'fire-detection',
    icon: Flame,
    title: 'Fire Detection & Suppression',
    summary: 'Aspirating smoke detection and gas-based suppression for critical facilities.',
    details: [
      'Aspirating (VESDA) smoke detection',
      'Gas-based suppression systems',
      'Addressable fire alarm networks',
      'Integration with BMS and evacuation',
    ],
  },
  {
    id: 'building-management',
    icon: Building2,
    title: 'Building Management Systems',
    summary: 'Centralised BMS integrating HVAC, lighting, energy and life-safety systems.',
    details: [
      'HVAC, lighting and energy automation',
      'Centralised monitoring and control',
      'Life-safety system integration',
      'Energy optimisation and reporting',
    ],
  },
  {
    id: 'it-networking',
    icon: Wifi,
    title: 'IT Networking & Wi-Fi',
    summary: 'Structured cabling, enterprise networking and resilient Wi-Fi infrastructure.',
    details: [
      'Structured cabling and data networking',
      'Enterprise-grade Wi-Fi coverage',
      'Network security and segmentation',
      'Redundant, high-availability design',
    ],
  },
  {
    id: 'paga-pids',
    icon: Radio,
    title: 'Audio-Video, PAGA & PIDS',
    summary: 'Public address, general alarm and perimeter intrusion detection systems.',
    details: [
      'Public Address & General Alarm (PAGA)',
      'Perimeter Intrusion Detection (PIDS)',
      'Conference and auditorium AV',
      'Integrated mass notification',
    ],
  },
]

export function SolutionsSection() {
  const [open, setOpen] = useState<number | null>(null)

  return (
    <section className="py-20 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mx-auto max-w-2xl text-center">
          <Reveal>
            <h2 className="text-balance text-3xl font-bold tracking-tight sm:text-4xl">
              End-to-end security &amp; automation, engineered as one system
            </h2>
          </Reveal>
          <Reveal index={1}>
            <p className="mt-4 text-pretty leading-relaxed text-muted-foreground">
              Six integrated disciplines, delivered by a single accountable partner. Expand each to
              see what we deliver.
            </p>
          </Reveal>
        </div>

        <div className="mt-14 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
          {SOLUTIONS.map((s, i) => {
            const Icon = s.icon
            const isOpen = open === i
            return (
              <Reveal key={s.title} index={i % 3}>
                <div
                  id={s.id}
                  className={`flex h-full flex-col rounded-xl border bg-card p-6 transition-all duration-300 ${
                    isOpen
                      ? 'border-primary/50 shadow-[0_0_40px_-12px_rgba(34,197,94,0.35)]'
                      : 'border-border hover:-translate-y-1 hover:border-primary/40'
                  }`}
                >
                  <div className="flex items-start justify-between gap-4">
                    <span className="flex h-11 w-11 items-center justify-center rounded-lg bg-primary/10 text-primary">
                      <Icon className="h-5 w-5" />
                    </span>
                    <button
                      type="button"
                      onClick={() => setOpen(isOpen ? null : i)}
                      aria-expanded={isOpen}
                      aria-label={isOpen ? `Collapse ${s.title}` : `Expand ${s.title}`}
                      className="flex h-8 w-8 items-center justify-center rounded-full border border-border text-muted-foreground transition-colors hover:border-primary hover:text-primary"
                    >
                      <Plus
                        className={`h-4 w-4 transition-transform duration-300 ${isOpen ? 'rotate-45' : ''}`}
                      />
                    </button>
                  </div>

                  <h3 className="mt-5 text-lg font-semibold">{s.title}</h3>
                  <p className="mt-2 text-sm leading-relaxed text-muted-foreground">{s.summary}</p>

                  <AnimatePresence initial={false}>
                    {isOpen && (
                      <motion.div
                        initial={{ height: 0, opacity: 0 }}
                        animate={{ height: 'auto', opacity: 1 }}
                        exit={{ height: 0, opacity: 0 }}
                        transition={{ duration: 0.3, ease: 'easeInOut' }}
                        className="overflow-hidden"
                      >
                        <div className="mt-5 border-t border-border pt-5">
                          {s.detailsTitle && (
                            <p className="mb-3 text-xs font-semibold uppercase tracking-wider text-primary">
                              {s.detailsTitle}
                            </p>
                          )}
                          <ul className="space-y-2.5">
                            {s.details.map((d) => (
                              <li key={d} className="flex items-start gap-2.5 text-sm text-muted-foreground">
                                <Check className="mt-0.5 h-4 w-4 shrink-0 text-primary" />
                                <span>{d}</span>
                              </li>
                            ))}
                          </ul>
                        </div>
                      </motion.div>
                    )}
                  </AnimatePresence>
                </div>
              </Reveal>
            )
          })}
        </div>
      </div>
    </section>
  )
}
