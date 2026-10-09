import type { CSSProperties } from 'react'
import { PROJECTS } from '@/lib/projects'

const clients = [...new Set(PROJECTS.map(({ client }) => client.trim()))]

// Duration is derived from the data at render time so server and client agree.
// Changing animation-duration after the animation starts makes the track jump.
const SECONDS_PER_CLIENT = 3.5
const marqueeDuration = Math.min(
  100,
  Math.max(80, clients.length * SECONDS_PER_CLIENT),
)

export function TrustMarquee() {
  return (
    <section className="border-y border-border bg-card/40 py-8" aria-label="Trusted by">
      <p className="mb-6 text-center text-xs font-medium uppercase tracking-[0.22em] text-muted-foreground">
        Trusted across India&apos;s most demanding facilities
      </p>
      <div className="sac-marquee-viewport relative overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_3%,black_97%,transparent)]">
        <div
          className="sac-marquee"
          style={{ '--sac-marquee-duration': `${marqueeDuration}s` } as CSSProperties}
        >
          {[false, true].map((isDuplicate) => (
            <ul
              key={isDuplicate ? 'duplicate' : 'primary'}
              className="sac-marquee-group flex shrink-0 items-center gap-12 pr-12"
              aria-hidden={isDuplicate || undefined}
              data-duplicate={isDuplicate || undefined}
            >
              {clients.map((name) => (
                <li
                  key={name}
                  className="whitespace-nowrap font-heading text-lg font-semibold tracking-tight text-foreground/70 transition-colors hover:text-primary"
                >
                  {name}
                </li>
              ))}
            </ul>
          ))}
        </div>
      </div>
    </section>
  )
}
