'use client'

import Link from 'next/link'
import { ArrowRight, Video, KeyRound, Flame, Building2, Wifi, Radio } from 'lucide-react'
import { Reveal } from '@/components/reveal'

const ITEMS = [
  { icon: Video, label: 'IP Video Surveillance' },
  { icon: KeyRound, label: 'Access Control' },
  { icon: Flame, label: 'Fire Detection & Suppression' },
  { icon: Building2, label: 'Building Management' },
  { icon: Wifi, label: 'IT Networking & Wi-Fi' },
  { icon: Radio, label: 'PAGA & PIDS' },
]

export function SolutionsTeaser() {
  return (
    <section className="border-y border-border bg-secondary/40 py-20 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mx-auto max-w-2xl text-center">
          <Reveal>
            <p className="text-sm font-semibold uppercase tracking-[0.2em] text-primary">
              What We Do
            </p>
          </Reveal>
          <Reveal index={1}>
            <h2 className="mt-4 text-balance text-3xl font-bold tracking-tight sm:text-4xl">
              Six integrated disciplines, one accountable partner
            </h2>
          </Reveal>
        </div>

        <div className="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-3">
          {ITEMS.map((item, i) => {
            const Icon = item.icon
            return (
              <Reveal key={item.label} index={i % 3}>
                <div className="flex h-full items-center gap-4 rounded-xl border border-border bg-card p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-primary/40">
                  <span className="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
                    <Icon className="h-5 w-5" />
                  </span>
                  <span className="text-sm font-medium leading-snug">{item.label}</span>
                </div>
              </Reveal>
            )
          })}
        </div>

        <Reveal index={1}>
          <div className="mt-10 text-center">
            <Link
              href="/solutions"
              className="group inline-flex items-center gap-1.5 text-sm font-semibold text-primary"
            >
              Explore all solutions
              <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
            </Link>
          </div>
        </Reveal>
      </div>
    </section>
  )
}
