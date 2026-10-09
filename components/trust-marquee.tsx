'use client'

import { useEffect, useRef } from 'react'
import { PROJECTS } from '@/lib/projects'

const clients = [...new Set(PROJECTS.map(({ client }) => client))]
const MARQUEE_PIXELS_PER_SECOND = 30

export function TrustMarquee() {
  const trackRef = useRef<HTMLDivElement>(null)
  const groupRef = useRef<HTMLDivElement>(null)

  useEffect(() => {
    const track = trackRef.current
    const group = groupRef.current
    if (!track || !group) return

    const updateDuration = () => {
      const duration = Math.max(
        120,
        group.scrollWidth / MARQUEE_PIXELS_PER_SECOND,
      )
      track.style.setProperty('--sac-marquee-duration', `${duration}s`)
    }

    updateDuration()
    const resizeObserver = new ResizeObserver(updateDuration)
    resizeObserver.observe(group)

    return () => resizeObserver.disconnect()
  }, [])

  return (
    <section className="border-y border-border bg-card/40 py-8" aria-label="Trusted by">
      <p className="mb-6 text-center text-xs font-medium uppercase tracking-[0.22em] text-muted-foreground">
        Trusted across India&apos;s most demanding facilities
      </p>
      <div className="relative overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_5%,black_95%,transparent)]">
        <div ref={trackRef} className="sac-marquee flex w-max items-center">
          {[false, true].map((isDuplicate) => (
            <div
              key={isDuplicate ? 'duplicate' : 'primary'}
              ref={isDuplicate ? undefined : groupRef}
              className="flex shrink-0 items-center gap-12 pr-12"
              aria-hidden={isDuplicate || undefined}
            >
              {clients.map((name) => (
                <span
                  key={name}
                  className="whitespace-nowrap font-heading text-lg font-semibold tracking-tight text-muted-foreground/80"
                >
                  {name}
                </span>
              ))}
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}
