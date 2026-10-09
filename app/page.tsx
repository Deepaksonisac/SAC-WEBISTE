import { Hero } from '@/components/hero'
import { AboutTeaser } from '@/components/home/about-teaser'
import { SolutionsTeaser } from '@/components/home/solutions-teaser'
import { ProjectsTeaser } from '@/components/home/projects-teaser'
import { CtaBand } from '@/components/cta-band'

export default function HomePage() {
  return (
    <>
      <Hero />
      <AboutTeaser />
      <SolutionsTeaser />
      <ProjectsTeaser />
      <CtaBand />
    </>
  )
}
