import Image from 'next/image'
import Link from 'next/link'
import { cn } from '@/lib/utils'

const LOGO_WIDTH = 1814
const LOGO_HEIGHT = 631

const VARIANTS = {
  header: {
    className: 'w-[132px] sm:w-[156px] lg:w-[176px] rounded-md',
    sizes: '(min-width: 1024px) 176px, (min-width: 640px) 156px, 132px',
  },
  footer: {
    className: 'w-[180px] rounded-lg',
    sizes: '180px',
  },
  menu: {
    className: 'w-[132px] rounded-md',
    sizes: '132px',
  },
} as const

export function SiteLogo({
  className,
  variant = 'header',
  priority = false,
}: {
  className?: string
  variant?: keyof typeof VARIANTS
  priority?: boolean
}) {
  const { className: sizeClassName, sizes } = VARIANTS[variant]

  return (
    <Link
      href="/"
      className={cn('flex shrink-0 items-center', className)}
      aria-label="Secure Automation Consultants home"
    >
      <Image
        src="/images/sac-logo-teal.png"
        alt="SAC — business is people"
        width={LOGO_WIDTH}
        height={LOGO_HEIGHT}
        sizes={sizes}
        priority={priority}
        className={cn('h-auto max-w-none object-contain shadow-sm', sizeClassName)}
      />
    </Link>
  )
}
