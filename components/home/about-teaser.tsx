'use client'

import Image from 'next/image'
import Link from 'next/link'
import { ArrowRight } from 'lucide-react'
import { Reveal } from '@/components/reveal'
import { StatsRow } from '@/components/stats-row'

export function AboutTeaser() {
  return (
    <section className="py-20 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid items-center gap-12 lg:grid-cols-2">
          <div>
            <Reveal>
              <p className="text-sm font-semibold uppercase tracking-[0.2em] text-primary">
                Who We Are
              </p>
            </Reveal>
            <Reveal index={1}>
              <h2 className="mt-4 text-balance text-3xl font-bold tracking-tight sm:text-4xl">
                A systems integrator engineered around your requirement
              </h2>
            </Reveal>
            <Reveal index={2}>
              <p className="mt-6 text-pretty leading-relaxed text-muted-foreground">
                Since 2010, Secure Automation Consultants has partnered with customers as an integral
                part of their requirement &mdash; engineering the right product mix to turn complex
                problems into future-proof, tailor-made solutions in Building Security, Management
                &amp; Automation.
              </p>
            </Reveal>
            <Reveal index={3}>
              <Link
                href="/about"
                className="group mt-7 inline-flex items-center gap-1.5 text-sm font-semibold text-primary"
              >
                Learn more about SAC
                <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
              </Link>
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
