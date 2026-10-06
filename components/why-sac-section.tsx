'use client'

import { Users, Scale, Gem } from 'lucide-react'
import { Reveal } from '@/components/reveal'

const PILLARS = [
  {
    icon: Users,
    title: 'Business is People',
    body: 'A people-first business model built on our organizational intellectual capital and deep engagement with every customer.',
  },
  {
    icon: Scale,
    title: 'Value for Money',
    body: 'Governance, financial discipline, performance management, customer focus and planning aimed at maximum value \u2014 not just lowest cost.',
  },
  {
    icon: Gem,
    title: 'People & Value',
    body: 'A culture built on Integrity, Excellence, Teamwork and Accountability in everything we design and deliver.',
  },
]

export function WhySacSection() {
  return (
    <section className="py-20 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mx-auto max-w-2xl text-center">
          <Reveal>
            <h2 className="text-balance text-3xl font-bold tracking-tight sm:text-4xl">
              Principles that hold up under pressure
            </h2>
          </Reveal>
        </div>

        <div className="mt-14 grid gap-6 md:grid-cols-3">
          {PILLARS.map((p, i) => {
            const Icon = p.icon
            return (
              <Reveal key={p.title} index={i}>
                <div className="group relative h-full overflow-hidden rounded-xl border border-primary/15 bg-secondary/50 p-8 transition-all duration-300 hover:-translate-y-1 hover:border-primary/40 hover:shadow-[0_0_40px_-12px_rgba(34,197,94,0.35)]">
                  <div
                    aria-hidden="true"
                    className="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-primary/5 blur-2xl transition-opacity duration-300 group-hover:opacity-100"
                  />
                  <span className="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 text-primary">
                    <Icon className="h-6 w-6" />
                  </span>
                  <h3 className="mt-6 text-xl font-semibold">{p.title}</h3>
                  <p className="mt-3 leading-relaxed text-muted-foreground">{p.body}</p>
                </div>
              </Reveal>
            )
          })}
        </div>
      </div>
    </section>
  )
}
