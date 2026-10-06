'use client'

import Image from 'next/image'
import { Quote } from 'lucide-react'
import { Reveal } from '@/components/reveal'

const LEADERS = [
  {
    name: 'Ankur Gupta',
    title: 'Key Decision Maker',
    image: '/images/leadership/ankur-gupta.jpeg',
    bio: 'An &ldquo;Engineer&rdquo; with &ldquo;non-Engineering&rdquo; grooming whose love for technology brought him to Low Voltage System Integration. With his team of 50+ at SAC, he leads consulting and design of LV solutions for high-rise buildings and industries, keeping the motto &ldquo;Business is People&rdquo; at a high state.',
  },
  {
    name: 'Ankit Maheshwari',
    title: 'Key Decision Maker',
    image: '/images/leadership/ankit-maheshwari.png',
    bio: 'An Engineer by qualification whose passion for business brought him to Low Voltage System Integration. With his team of 50+ at SAC, he leads consulting and design of LV solutions across various industries, keeping the motto &ldquo;Business is People&rdquo; at a high state.',
  },
  {
    name: 'Varsha Gupta',
    title: 'Director, Commercial & Administration',
    image: '/images/leadership/varsha-gupta.jpeg',
    bio: 'A passionate leader with 19+ years across IT, Telecom, Finance &amp; Technology. As Chief Strategist she guides her 50+ team in consulting and designing Low Voltage solutions for high-rise buildings and industries, her entrepreneurial spirit taking SAC to new heights.',
  },
]

export function LeadershipSection() {
  return (
    <section className="scroll-mt-20 border-t border-border bg-card/30 py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="mx-auto max-w-2xl text-center">
          <Reveal>
            <p className="text-sm font-semibold uppercase tracking-[0.2em] text-primary">
              Leadership
            </p>
          </Reveal>
          <Reveal index={1}>
            <h2 className="mt-4 text-balance text-3xl font-bold tracking-tight sm:text-4xl">
              The people behind the engineering
            </h2>
          </Reveal>
        </div>

        <div className="mt-14 grid gap-6 md:grid-cols-3">
          {LEADERS.map((leader, i) => (
            <Reveal key={leader.name} index={i}>
              <article className="group h-full overflow-hidden rounded-xl border border-border bg-card transition-all duration-300 hover:-translate-y-1 hover:border-primary/40 hover:shadow-[0_0_40px_-12px_rgba(34,197,94,0.35)]">
                <div className="relative aspect-[4/5] overflow-hidden">
                  <Image
                    src={leader.image}
                    alt={`Portrait of ${leader.name}`}
                    fill
                    className="object-cover object-center transition-transform duration-500 group-hover:scale-105"
                    sizes="(max-width: 768px) 100vw, 33vw"
                  />
                  
                </div>
                <div className="p-6">
                  <h3 className="text-lg font-semibold">{leader.name}</h3>
                  <p className="mt-1 text-sm font-medium text-primary">{leader.title}</p>
                  <p
                    className="mt-3 text-sm leading-relaxed text-muted-foreground"
                    dangerouslySetInnerHTML={{ __html: leader.bio }}
                  />
                </div>
              </article>
            </Reveal>
          ))}
        </div>

        <Reveal index={1}>
          <div className="mx-auto mt-14 flex max-w-3xl items-center justify-center gap-4 rounded-xl border border-primary/25 bg-primary/5 px-8 py-10 text-center">
            <Quote className="hidden h-8 w-8 shrink-0 text-primary sm:block" />
            <p className="font-heading text-2xl font-bold tracking-tight sm:text-3xl">
              &ldquo;Business is People.&rdquo;
            </p>
          </div>
        </Reveal>
      </div>
    </section>
  )
}





