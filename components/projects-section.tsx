'use client'

import Image from 'next/image'
import { useMemo, useState } from 'react'
import { AnimatePresence, motion } from 'framer-motion'
import { MapPin } from 'lucide-react'
import { Reveal } from '@/components/reveal'
import { PROJECTS, type Industry } from '@/lib/projects'

const FILTERS: (Industry | 'All')[] = [
  'All',
  'Hospitality',
  'Healthcare',
  'Infrastructure & Commercial',
  'Industrial',
]

export function ProjectsSection() {
  const [filter, setFilter] =
    useState<(typeof FILTERS)[number]>('All')

  const visible = useMemo(
    () =>
      filter === 'All'
        ? PROJECTS
        : PROJECTS.filter((p) => p.industry === filter),
    [filter],
  )

  return (
    <section className="py-20 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <Reveal>
          <div className="flex flex-wrap justify-center gap-3">
            {FILTERS.map((f) => (
              <button
                key={f}
                type="button"
                onClick={() => setFilter(f)}
                className={`rounded-full border px-5 py-2 text-sm font-medium transition-colors ${
                  filter === f
                    ? 'border-primary bg-primary text-primary-foreground'
                    : 'border-border text-muted-foreground hover:border-primary/50 hover:text-foreground'
                }`}
              >
                {f}
              </button>
            ))}
          </div>
        </Reveal>

        <motion.div
          layout
          className="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3"
        >
          <AnimatePresence mode="popLayout">
            {visible.map((p) => (
              <motion.article
                key={`${p.client}-${p.location}`}
                layout
                initial={{ opacity: 0, scale: 0.96 }}
                animate={{ opacity: 1, scale: 1 }}
                exit={{ opacity: 0, scale: 0.96 }}
                transition={{ duration: 0.35 }}
                className="group flex flex-col overflow-hidden rounded-xl border border-border bg-card transition-colors hover:border-primary/40"
              >
                <div className="relative h-[260px] sm:h-[290px] overflow-hidden">
                  <Image
                    src={p.image}
                    alt={`${p.client} project site`}
                    fill
                    className="object-cover object-center transition-transform duration-500 group-hover:scale-105"
                    sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw"
                  />

                  

                  <span className="absolute left-3 top-3 rounded-full border border-border bg-background/80 px-3 py-1 text-xs font-medium text-foreground backdrop-blur">
                    {p.industry}
                  </span>
                </div>

                <div className="flex flex-1 flex-col p-6">
                  <h3 className="text-base font-semibold leading-snug">
                    {p.client}
                  </h3>

                  <p className="mt-2 flex items-center gap-1.5 text-sm text-muted-foreground">
                    <MapPin className="h-3.5 w-3.5 text-primary" />
                    {p.location}
                  </p>

                  <div className="mt-4 flex flex-wrap gap-2">
                    {p.tags.map((tag) => (
                      <span
                        key={tag}
                        className="rounded-md bg-secondary px-2.5 py-1 text-xs text-secondary-foreground"
                      >
                        {tag}
                      </span>
                    ))}
                  </div>
                </div>
              </motion.article>
            ))}
          </AnimatePresence>
        </motion.div>
      </div>
    </section>
  )
}










