'use client'

import Image from 'next/image'
import { Reveal } from '@/components/reveal'
import { StatsRow } from '@/components/stats-row'

export function CompanyOverview() {
  return (
    <section className="py-20 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid items-center gap-12 lg:grid-cols-2">
          <div>
            <Reveal>
              <p className="text-sm font-semibold uppercase tracking-[0.2em] text-primary">
                Company Overview
              </p>
            </Reveal>
            <Reveal index={1}>
              <h2 className="mt-4 text-balance text-3xl font-bold tracking-tight sm:text-4xl">
                Partnering as an integral part of your requirement
              </h2>
            </Reveal>
            <Reveal index={2}>
              <p className="mt-6 text-pretty leading-relaxed text-muted-foreground">
                Secure Automation Consultants partners with customers as an integral part of their
                requirement &mdash; engineering the right product mix to turn complex problems into
                future-proof, tailor-made solutions in Building Security, Management &amp; Automation.
              </p>
            </Reveal>
            <Reveal index={3}>
              <p className="mt-4 text-pretty leading-relaxed text-muted-foreground">
                Since 2010 we have designed, deployed and maintained integrated security and
                automation ecosystems across oil &amp; gas, power, cement, government and smart
                cities, hospitality, healthcare, education and aviation &mdash; delivered by a single
                accountable team.
              </p>
            </Reveal>
          </div>

          <Reveal index={1}>
            <div className="relative overflow-hidden rounded-xl border border-border shadow-sm">
              <Image
                src="/images/about-control-room.png"
                alt="Modern security operations center with a video wall of surveillance feeds"
                width={880}
                height={620}
                className="h-full w-full object-cover"
              />
              <div className="pointer-events-none absolute inset-0 ring-1 ring-inset ring-primary/10" />
            </div>
          </Reveal>
        </div>

        <div className="mt-16">
          <StatsRow />
        </div>
      </div>
    </section>
  )
}
