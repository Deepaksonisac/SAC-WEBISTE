'use client'

import Image from 'next/image'
import Link from 'next/link'
import { ArrowRight, MapPin } from 'lucide-react'
import { Reveal } from '@/components/reveal'

const FEATURED = [
  {
    client: 'Taj Sawai Man Mahal (Rambagh)',
    location: 'Jaipur',
    industry: 'Hospitality',
    image: '/images/projects/taj-sawai-man-mahal.avif',
    tags: ['BMS', 'Access Control', 'ELV Systems'],
  },
  {
    client: 'SMS Super Specialty Hospital',
    location: 'Jaipur',
    industry: 'Healthcare',
    image: '/images/projects/sms-super-specialty-hospital.avif',
    tags: ['BMS', 'Security Systems', 'ELV Systems'],
  },
  {
    client: 'Ayodhya Airport',
    location: 'Ayodhya',
    industry: 'Infrastructure & Commercial',
    image: '/images/projects/ayodhya-airport.jpg',
    tags: ['Integrated ELV', 'Security Systems', 'Automation'],
  },
]

export function ProjectsTeaser() {
  return (
    <section className="py-20 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
          <div className="max-w-2xl">
            <Reveal>
              <p className="text-sm font-semibold uppercase tracking-[0.2em] text-primary">
                Featured Projects
              </p>
            </Reveal>
            <Reveal index={1}>
              <h2 className="mt-4 text-balance text-3xl font-bold tracking-tight sm:text-4xl">
                Trusted on India&apos;s most critical sites
              </h2>
            </Reveal>
          </div>
          <Reveal index={1}>
            <Link
              href="/projects"
              className="group inline-flex items-center gap-1.5 text-sm font-semibold text-primary"
            >
              View all projects
              <ArrowRight className="h-4 w-4 transition-transform group-hover:translate-x-1" />
            </Link>
          </Reveal>
        </div>

        <div className="mt-12 grid gap-6 md:grid-cols-3">
          {FEATURED.map((p, i) => (
            <Reveal key={p.client} index={i}>
              <article className="group flex h-full flex-col overflow-hidden rounded-xl border border-border bg-card shadow-sm transition-colors hover:border-primary/40">
                <div className="relative aspect-[16/10] overflow-hidden">
                  <Image
                    src={p.image}
                    alt={`${p.client} project site`}
                    fill
                    className="object-cover transition-transform duration-500 group-hover:scale-105"
                    sizes="(max-width: 768px) 100vw, 33vw"
                  />
                  <span className="absolute left-3 top-3 rounded-full border border-border bg-background/80 px-3 py-1 text-xs font-medium text-foreground backdrop-blur">
                    {p.industry}
                  </span>
                </div>
                <div className="flex flex-1 flex-col p-6">
                  <h3 className="text-base font-semibold leading-snug">{p.client}</h3>
                  <p className="mt-2 flex items-center gap-1.5 text-sm text-muted-foreground">
                    <MapPin className="h-3.5 w-3.5 text-primary" />
                    {p.location}
                  </p>
                  <div className="mt-4 flex flex-wrap gap-2">
                    {p.tags.map((t) => (
                      <span
                        key={t}
                        className="rounded-md bg-secondary px-2.5 py-1 text-xs text-secondary-foreground"
                      >
                        {t}
                      </span>
                    ))}
                  </div>
                </div>
              </article>
            </Reveal>
          ))}
        </div>
      </div>
    </section>
  )
}

