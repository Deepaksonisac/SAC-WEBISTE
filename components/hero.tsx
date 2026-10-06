'use client'

import dynamic from 'next/dynamic'
import Link from 'next/link'
import { motion, type Variants } from 'framer-motion'
import { ArrowRight, ShieldCheck } from 'lucide-react'
import { Button } from '@/components/ui/button'

const HeroScene = dynamic(() => import('@/components/hero-scene').then((m) => m.HeroScene), {
  ssr: false,
  loading: () => (
    <div
      aria-hidden="true"
      className="h-full w-full"
      style={{
        background:
          'radial-gradient(60% 60% at 70% 40%, rgba(34,197,94,0.22), rgba(240,247,240,0) 70%)',
      }}
    />
  ),
})

const container = {
  hidden: {},
  visible: { transition: { staggerChildren: 0.12, delayChildren: 0.1 } },
}
const item: Variants = {
  hidden: { opacity: 0, y: 24 },
  visible: { opacity: 1, y: 0, transition: { duration: 0.6, ease: [0.22, 1, 0.36, 1] } },
}

export function Hero() {
  return (
    <section id="home" className="relative min-h-[100svh] overflow-hidden">
      {/* 3D scene layer */}
      <div className="absolute inset-0 z-0">
        <HeroScene />
      </div>

      {/* gradient legibility overlay */}
      <div
        aria-hidden="true"
        className="absolute inset-0 z-10 bg-gradient-to-r from-background via-background/85 to-background/30 md:to-transparent"
      />
      <div
        aria-hidden="true"
        className="absolute inset-x-0 bottom-0 z-10 h-40 bg-gradient-to-t from-background to-transparent"
      />

      <div className="relative z-20 mx-auto flex min-h-[100svh] max-w-7xl flex-col justify-center px-4 pt-24 pb-16 sm:px-6 lg:px-8">
        <motion.div
          variants={container}
          initial="hidden"
          animate="visible"
          className="max-w-2xl"
        >
          <motion.div
            variants={item}
            className="mb-6 inline-flex items-center gap-2 rounded-full border border-border bg-card/60 px-4 py-1.5 text-xs font-medium text-muted-foreground backdrop-blur"
          >
            <ShieldCheck className="h-3.5 w-3.5 text-primary" />
            Building Security, Management &amp; Automation &middot; Jaipur, India
          </motion.div>

          <motion.h1
            variants={item}
            className="text-balance text-4xl font-bold leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl"
          >
            Engineering Trust <span className="text-primary">Since 2010</span>
          </motion.h1>

          <motion.p
            variants={item}
            className="mt-6 max-w-xl text-pretty text-base leading-relaxed text-muted-foreground sm:text-lg"
          >
            Secure Automation Consultants designs and delivers tailor-made Building Security,
            Management &amp; Automation solutions for India&apos;s most demanding facilities.
          </motion.p>

          <motion.div variants={item} className="mt-9 flex flex-col gap-3 sm:flex-row">
            <Button
              size="lg"
              className="group"
              nativeButton={false}
              render={
                <Link href="/solutions">
                  Explore Solutions
                  <ArrowRight className="ml-1 h-4 w-4 transition-transform group-hover:translate-x-1" />
                </Link>
              }
            />
            <Button
              size="lg"
              variant="outline"
              className="border-border bg-card/40 backdrop-blur"
              nativeButton={false}
              render={<Link href="/projects">View Our Projects</Link>}
            />
          </motion.div>
        </motion.div>
      </div>
    </section>
  )
}
