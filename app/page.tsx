import { Hero } from '@/components/hero'
import { AboutTeaser } from '@/components/home/about-teaser'
import { SolutionsTeaser } from '@/components/home/solutions-teaser'
import { CtaBand } from '@/components/cta-band'

export default function HomePage() {
  return (
    <>
      <Hero />
      <AboutTeaser />
      <SolutionsTeaser />
      <CtaBand />
    </>
  )
}
