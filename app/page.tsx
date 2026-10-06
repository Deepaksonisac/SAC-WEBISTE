import { Hero } from '@/components/hero'
import { TrustMarquee } from '@/components/trust-marquee'
import { AboutTeaser } from '@/components/home/about-teaser'
import { SolutionsTeaser } from '@/components/home/solutions-teaser'
import { ProjectsTeaser } from '@/components/home/projects-teaser'
import { CtaBand } from '@/components/cta-band'

export default function HomePage() {
  return (
    <>
      <Hero />
      <TrustMarquee />
      <AboutTeaser />
      <SolutionsTeaser />
      <ProjectsTeaser />
      <CtaBand />
    </>
  )
}
